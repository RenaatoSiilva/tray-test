<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'register')->name('api.register');
    Route::post('/auth/login', 'login')->name('api.login');
    Route::post('/auth/recovery-password', 'recoveryPassword')->name('api.recovery-password');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(SellerController::class)->group(function () {
        Route::get('/seller/list/{sellerId?}', 'list')->name('list.get-seller');
        Route::post('/seller/store', 'store')->name('api.store-seller');
        Route::put('/seller/update/{sellerId}', 'update')->name('api.update-seller');
        Route::delete('/seller/destroy/{sellerId}', 'destroy')->name('api.delete-seller');
    });

    Route::controller(SaleController::class)->group(function () {
        Route::get('/sale/list/{saleId?}', 'list')->name('list.get-sale');
        Route::post('/sale/store', 'store')->name('api.store-sale');
        Route::put('/sale/update/{saleId}', 'update')->name('api.update-sale');
        Route::delete('/sale/destroy/{saleId}', 'destroy')->name('api.delete-sale');
        Route::get('/sale/listBySeller/{sellerId?}', 'listSalesBySellerId')->name('api.get-sales-by-seller');
        Route::post('/sale/send-commission-report', 'sendCommissionReport')->name('api.send-commission-report');
        Route::get('/sale/listBySellerGroupedDays/{sellerId}', 'listSalesBySellerIdWithGroupedByDays')->name('api.list-sales-by-seller-grouped-days');
    });
});
