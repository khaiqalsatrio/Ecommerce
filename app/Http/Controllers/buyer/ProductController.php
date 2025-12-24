<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // Untuk halaman list products
    public function index()
    {
        $products = Product::with('category')
            ->where('status', 'active')
            ->get();

        return view('buyer.layout.products-real', compact('products'));
    }

    // Untuk halaman detail product
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        return view('buyer.product-show', compact('product'));
    }
}
