<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\PaymentController;

Route::prefix('v1')->group(function () {
    // Merchant API endpoints
    Route::post('/merchant/check-user', [MerchantController::class, 'checkUser']);
    Route::post('/merchant/check-balance', [MerchantController::class, 'checkBalance']);

    // Payment API endpoints
    Route::post('/payment/topup', [PaymentController::class, 'topup']);
    Route::post('/payment/qr/generate', [PaymentController::class, 'generateQR']);
    Route::post('/payment/qr/pay', [PaymentController::class, 'paymentQR']);
});
