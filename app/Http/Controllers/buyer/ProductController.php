<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('images', 'category')
            ->where('status', 'active')
            ->get();
    }

    public function show($slug)
    {
        return Product::where('slug', $slug)
            ->with('images', 'reviews.user')
            ->firstOrFail();
    }
}
