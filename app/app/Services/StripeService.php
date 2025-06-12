<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.client_secret'));
    }

    public function createPaymentIntent(int $amountInUSD, int $userId): PaymentIntent
    {
        return PaymentIntent::create([
            'amount' => $amountInUSD * 100, // convert to cents
            'currency' => 'usd',
            'metadata' => [
                'user_id' => $userId,
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
            ],
        ]);
    }
}
