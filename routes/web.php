<?php

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/order', function () {

    $order = Order::where('id', 1)->first();

    $order_items = OrderItem::where('id', 1)->first();

    dd($order->items);
    return view('welcome');
});