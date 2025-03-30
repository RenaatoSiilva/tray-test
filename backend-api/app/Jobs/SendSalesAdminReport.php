<?php

namespace App\Jobs;

use App\Mail\AdminSalesReport;
use App\Models\Sale;
use App\Models\User;
use App\Repositories\SaleRepository\SaleRepository;
use App\Repositories\UserRepository\UserRepository;
use App\Services\SaleService\SaleService;
use App\Services\UserService\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendSalesAdminReport implements ShouldQueue
{
    use Queueable;

    public $userService;
    public $saleService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository(new User()));
        $this->saleService = new SaleService(new SaleRepository(new Sale()));
        $this->onQueue(config('queue.sales_admin_report'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $date = Carbon::now()->toDateString();

        /** Let's Think All Users Are Admin :) */
        $users = $this->userService->get(null);
        $sales = $this->saleService->getByDate($date);
        $csvData   = $this->generateCsv($sales);
        $csvPath = storage_path('app/' . $csvData);

        foreach ($users as $user) {

            Mail::to($user->email)->send(new AdminSalesReport($csvPath, $date));
        }
    }

    private function generateCsv($sales)
    {

        $csvFileName = 'sales_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $csvPath = storage_path('app/' . $csvFileName);

        $handle = fopen($csvPath, 'w');

        fputcsv($handle, ['Vendedor', 'Valor Total', 'Comissão (%)', 'Valor da Comissão']);

        $totalSales         = 0;
        $totalCommission    = 0;

        foreach ($sales as $sale) {
            $totalSales = $sale->amount + $totalSales;
            $totalCommission = $sale->commission_value + $totalCommission;
            fputcsv($handle, [
                $sale->seller->name,
                $sale->amount,
                $sale->commission,
                $sale->commission_value
            ]);
        }

        fputcsv($handle, []);
        fputcsv($handle, ['Comissões Totais', $totalCommission]);
        fputcsv($handle, ['Vendas Totais', $totalSales]);

        fclose($handle);

        return $csvFileName;
    }
}
