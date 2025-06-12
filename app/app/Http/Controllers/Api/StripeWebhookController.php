<?php

namespace App\Http\Controllers\Api;

use Stripe\Webhook;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class StripeWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(App::environment('prod')){
            $payload = @file_get_contents('php://input');
            $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;
            $secret = config('services.stripe.webhook_secret');

            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $secret);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Invalid signature'], 400);
            }
        }else{
            $event = json_decode(json_encode($request->all())); 
        }
        
        if(!$event){
            return response()->json(['message' => 'Invalid signature'], 400);
        }
        
        if ($event->type == 'payment_intent.succeeded') {
            $intent = $event->data->object;

            $order = Order::with('products')->where('stripe_payment_intent_id', $intent->id)->first();

            if (! $order || $order->payment_status == Order::STATUS_PAID) {
                return response()->json(['message' => 'Order not found or already paid.'], 400);
            }
            
            try {
                DB::transaction(function () use ($order) {
                    foreach ($order->products as $item) {
                        $product = Product::lockForUpdate()->findOrFail($item->id);
                        if ($product->quantity < $item->pivot->quantity) {
                            return response()->json(['message' => "Insufficient stock for product: {$product->name}"], 500);
                        }

                        $product->decrement('quantity', $item->pivot->quantity);
                    }

                    $order->update(['payment_status' => Order::STATUS_PAID]);
                });

                return response()->json(['message' => 'Order paid successfully'], 200);

            } catch (\Exception $e) {
                return response()->json(['message' => 'Stock update failed'], 500);
            }
        }

        return response()->json(['message' => 'Event failed'], 200);
    }
}
