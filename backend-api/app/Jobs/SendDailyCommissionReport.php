<?php

namespace App\Jobs;

use App\Mail\CommissionReport;
use App\Models\Sale;
use App\Models\Seller;
use App\Repositories\SaleRepository\SaleRepository;
use App\Repositories\SellerRepository\SellerRepository;
use App\Services\SaleService\SaleService;
use App\Services\SellerService\SellerService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDailyCommissionReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue(config('queue.commissions_report_daily'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $salesService = new SaleService(new SaleRepository(new Sale()));
        $sellerService = new SellerService(new SellerRepository(new Seller()));

        $date = Carbon::now()->toDateString();

        $sellers = $sellerService->get(null);

        foreach ($sellers as $seller) {

            $sales = $salesService->getSalesBySellerIdAndDate(sellerId: $seller->id, date: $date);

            Mail::to($seller->email)->send(new CommissionReport($seller->name, $sales, $date));

            sleep(5);
        }
    }
}
