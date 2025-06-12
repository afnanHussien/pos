<?php

use App\Http\Controllers\Api\User\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ProductController;

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'login']); 
    Route::middleware(['auth:sanctum', 'auth.role:user'])->group(function () {
        Route::post('/logout', [AuthController::class,'logout']);

        Route::apiResource('/products', ProductController::class);
        Route::apiResource('/orders', OrderController::class);
    });
});