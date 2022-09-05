<?php

use App\Http\Controllers\Api\V1\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
   Route::post('/payment',[PaymentController::class, 'payment']);
});

Route::post('/payment-webhook',[PaymentController::class, 'webhook']);
