<?php

namespace App\Jobs;

use App\Mail\CommissionReport;
use App\Models\Sale;
use App\Models\Seller;
use App\Repositories\SaleRepository\SaleRepository;
use App\Repositories\SellerRepository\SellerRepository;
use App\Services\SaleService\SaleService;
use App\Services\SellerService\SellerService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendCommissionReport implements ShouldQueue
{
    use Queueable;

    public int $sellerId;
    public string $date;

    /**
     * Create a new job instance.
     */
    public function __construct($sellerId, $date)
    {
        $this->sellerId = $sellerId;
        $this->date     = $date;
        $this->onQueue(config('queue.commissions_report'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $salesService = new SaleService(new SaleRepository(new Sale()));
        $sellerService = new SellerService(new SellerRepository(new Seller()));

        $seller = $sellerService->get($this->sellerId);

        $sales = $salesService->getSalesBySellerIdAndDate(sellerId: $this->sellerId, date: $this->date);
    
        Mail::to($seller->email)->send(new CommissionReport($seller->name, $sales, $this->date));


    }
}
