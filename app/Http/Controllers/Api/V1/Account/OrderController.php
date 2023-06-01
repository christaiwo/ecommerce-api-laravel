<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\Account\StoreOrderRequest;
use App\Http\Requests\V1\Account\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->get();
        return response()->json([
            'orders' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        // check if user just enter a new address for payment
        if($data['order']['address_id'] == 'new'){
            $addressData = [
                'address' => $data['address']['address'],
                'address2' => $data['address']['address2'],
                'city' => $data['address']['city'],
                'region' => $data['address']['region'],
                'zip' => $data['address']['zip'],
                'country' => $data['address']['country'],
            ];

            $address = Auth::user()->address()->create($addressData);

            $orderId = $address->id;
        }

        // insert order data into the database
        $order = $request->user()->orders()->create([
            'address_id' => $orderId ?? $data['order']['address_id'],
            'hash' => Str::random(30),
            'amount'=> $data['order']['amount'],
            'payment_method' => $data['order']['payment_method'],
        ]);

        // loop through the items to store them in different tables 
        foreach($data['order_items'] as $item){
            $orderItem = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
            $order->items()->create($orderItem);
        }
        
        return response()->json([
            'order' => $order->load('items')
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items' => function ($query) {
            $query->with('product');
        }]);
        
        return response()->json([
            'order' => $order
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([], 200);
    }
}
