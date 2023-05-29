<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreCategoryRequest;
use App\Http\Requests\V1\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(compact('categories'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        
        // save image into the system folder
        if(request('image')){

            // save image to product folder
            $imagePath = $data['image']->store('product', 'public');
            // resize image 
            // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000)->save();
        }

        $category = Category::create([
            'name' => $data['name'],
            'image' => $imagePath
        ]);

        return response()->json(compact('category'), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(compact('category'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if(request('image')){

            // save image to product folder
            $imagePath = $data['image']->store('product', 'public');
            // resize image 
            // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000)->save();
        }
        $category = $category->update([
            'name' => $data['name'],
            'image' => $imagePath ?? $category->image
        ]);

        return response()->json(compact('category'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([''], 200);
    }
}
