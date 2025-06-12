<?php

use App\Http\Controllers\Api\StripeWebhookController;
use Illuminate\Support\Facades\Route;


Route::post('/stripe-webhook', StripeWebhookController::class);

require __DIR__.'/../routes/partial_apis/admin.php';
require __DIR__.'/../routes/partial_apis/user.php';