<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_users'    => User::count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'paid_orders'    => Order::where('payment_status', 'paid')->count(),
            'total_income'   => Payment::where('status', 'success')->sum('order_id')
        ]);
    }
}
