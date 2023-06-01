<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// group this route by Version 1 of this software
Route::group(['prefix' => 'v1'], function(){
    
    // group this route by account
    Route::group(['prefix' => 'account'], function(){
        Route::post('/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']); 
        Route::post('/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']); 

        // all middleware route for authenticated users
        Route::group(['middleware' => 'auth:sanctum'], function(){
            Route::post('/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']); 

            Route::apiResource('/address', \App\Http\Controllers\Api\V1\Account\AddressController::class);
            Route::apiResource('/order', \App\Http\Controllers\Api\V1\Account\OrderController::class);
        });
    });


    // group this route by account
    Route::group(['prefix' => 'admin'], function(){
        // all middleware route for authenticated users
        Route::group(['middleware' => 'auth:sanctum'], function(){
            Route::apiResource('/category', \App\Http\Controllers\Api\V1\Admin\CategoryController::class);
            Route::apiResource('/product', \App\Http\Controllers\Api\V1\Admin\ProductController::class);
        });
    });

});