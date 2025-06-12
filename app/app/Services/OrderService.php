<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected StripeService $stripeService) {}

    public function placeOrder(array $items, $user)
    {
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    abort(400, "Insufficient stock for product: {$product->name}");
                }

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ];

                $totalAmount += $product->price * $item['quantity'];
            }
            
            $intent = $this->stripeService->createPaymentIntent($totalAmount,$user->id );

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'payment_status' => Order::STATUS_PENDING,
                'stripe_payment_intent_id' => $intent->id,
            ]);

            foreach ($orderItems as $itemData) {
                $order->items()->create($itemData);
            }

            DB::commit();

            return [
                'order' => $order,
                'client_secret' => $intent->client_secret
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, "Order failed. " . $e->getMessage());
        }
    }
}