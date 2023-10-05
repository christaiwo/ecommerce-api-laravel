<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreProductRequest;
use App\Http\Requests\V1\Admin\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(compact('products'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        
        // save image into the system folder
        if($data['image']){

            // save image to product folder
            $imagePath = $data['image']->store('product', 'public');
            // resize image 
            // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000)->save();
        }


        $product = Product::create([
            'category_id' => $data['category_id'],
            'image' => url('storage/'.$imagePath.''),
            'name' => $data['name'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'total' => $data['total'],
            'sold' => $data['sold'],
        ]);

        return response()->json(compact('product'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json(compact('product'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        // save image into the system folder
        // if($data['image']){

        //     // save image to product folder
        //     $imagePath = $data['image']->store('product', 'public');
        //     // resize image 
        //     // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000)->save();
        // }

        $product = $product->update([
            'category_id' => $data['category_id'],
            // 'image' => url('storage/'.$imagePath.'') ?? $product->image,
            'name' => $data['name'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'total' => $data['total'],
            'sold' => $data['sold'],
        ]);

        return response()->json(compact('product'), 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([''], 200);
    }
}
