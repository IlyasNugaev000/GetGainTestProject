<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/offers')->group(function () {
    Route::get('', [OfferController::class, 'getOffers'])->name('getOffers');
    Route::middleware('auth:sanctum')->delete('/{id}', [OfferController::class, 'softDeleteOffer'])->name('softDeleteOffer');
    Route::middleware('auth:sanctum')->post('/{id}', [OfferController::class, 'restoreOffer'])->name('restoreOffer');
});

Route::prefix('/products')->group(function () {
    Route::get('/{id}/sellers', [SellerController::class, 'getSellers'])->name('getSellers');
});
