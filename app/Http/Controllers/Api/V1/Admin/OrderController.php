<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json(compact('orders'), 200);
    }

    public function show(Order $order)
    {
        return response()->json(compact('$order'), 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([''], 200);
    }
}
