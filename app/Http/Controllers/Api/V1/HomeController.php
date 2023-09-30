<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(20);
        return response()->json([
            'categories' => $categories->load('products'),
            'products' => $products->load('category')
        ],200);
    }

    public function category(Category $category)
    {
        return response()->json([
            'category' => $category->load('products')
        ],200);
    }

    public function product(Product $product)
    {
        return response()->json([
            'product' => $product->load('category')
        ],200);
    }

    public function products()
    {
        $products = Product::paginate(20);
        return response()->json([
            'product' => $products
        ],200);
    }
}
