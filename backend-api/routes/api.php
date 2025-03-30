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
        Route::get('/sellers/list/{sellerId?}', 'list');
        Route::post('/sellers/store', 'store');
        Route::put('/sellers/update/{sellerId}', 'update');
        Route::delete('/sellers/destroy/{sellerId}', 'destroy')->name('api.update-seller');
    });

    Route::controller(SaleController::class)->group(function () {
        Route::get('/sales/list/{saleId?}', 'list');
        Route::post('/sales/store', 'store');
        Route::put('/sales/update/{saleId}', 'update');
        Route::delete('/sales/destroy/{saleId}', 'destroy');
        Route::get('/sales/listBySeller/{sellerId?}', 'listSalesBySellerId');
        Route::post('/sales/send-commission-report', 'sendCommissionReport');
        Route::get('/sales/listBySellerGroupedDays/{sellerId}', 'listSalesBySellerIdWithGroupedByDays');
    });
});
