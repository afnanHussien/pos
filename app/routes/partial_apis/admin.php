<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ProductController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']); 
    Route::middleware(['auth:sanctum', 'auth.role:admin'])->group(function () {
        Route::post('/logout', [AuthController::class,'logout']);

        Route::apiResource('/products', ProductController::class);
    });
});