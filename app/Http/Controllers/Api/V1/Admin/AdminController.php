<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $order = Order::all();
        $product = Product::all();
        $customer = User::all();
        return response()->json([
            'count' => [
                'order' => $order->count(),
                'product' => $product->count(),
                'customer' => $customer->count()
            ],
            'sum' => [
                'order' => $order->sum('amount'),
                'product' => $product->sum('amount'),
                'customer' => $customer->count()
            ]
        ], 200);
    }
}