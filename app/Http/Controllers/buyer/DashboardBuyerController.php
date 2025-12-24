<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardBuyerController extends Controller
{
    public function index()
    {
        return view('buyer.home', [
            'products' => Product::latest()->take(8)->get()
        ]);
    }
}
