<?php

// Namespace controller untuk area admin
namespace App\Http\Controllers\Admin;

// Import base Controller Laravel
use App\Http\Controllers\Controller;

// Import model User
use App\Models\User;

// Import model Product
use App\Models\Product;

// Import model Order
use App\Models\Order;

// Import model Payment
use App\Models\Payment;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        // Kirim data statistik ke view admin.home
        return view('admin.home', [
            'total_users'    => User::count(),                                   // Total semua user
            'total_products' => Product::count(),                                // Total semua produk
            'total_orders'   => Order::count(),                                  // Total semua order
            'paid_orders'    => Order::where('payment_status', 'paid')->count(), // Total order yang sudah dibayar
            'total_income'   => Payment::where('status', 'success')->sum('amount'), // Total pendapatan sukses
        ]);

        // ❌ Kode di bawah ini tidak akan pernah dijalankan
        // karena return di atas sudah menghentikan proses
        return view('admin.dashboard', compact('sales'));
    }
}
