<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->latest()->paginate(10);
        // return response()->json($orders);
        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, OrderService $orderService)
    {
        $result = $orderService->placeOrder($request->validated()['items'], auth()->user());

        return response()->json([
            'message' => 'Order placed successfully. Confirm payment to complete.',
            'order_id' => $result['order']->id,
            'client_secret' => $result['client_secret'],
        ]);
    }

}
