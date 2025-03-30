<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\Seller;
use App\Repositories\SaleRepository\SaleRepository;
use App\Services\SaleService\SaleService;

class SellerObserver
{
    /**
     * Handle the Seller "created" event.
     */
    public function created(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "updated" event.
     */
    public function updated(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "deleted" event.
     */
    public function deleted(Seller $seller): void
    {

        $saleService = new SaleService(new SaleRepository(new Sale()));

        $saleService->deleteBySellerId($seller->id);
    }

    /**
     * Handle the Seller "restored" event.
     */
    public function restored(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     */
    public function forceDeleted(Seller $seller): void
    {
        //
    }
}
