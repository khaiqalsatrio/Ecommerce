<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    /**
     * TAMPILKAN SEMUA ORDER (VIEW)
     */
    public function index()
    {
        $orders = Order::with(['items.product', 'payment', 'user'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    /**
     * DETAIL ORDER
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'user']);

        return view('admin.orders-show', compact('order'));
    }

    /**
     * VERIFIKASI PEMBAYARAN
     */
    public function verify(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'status'         => 'paid',
        ]);

        if ($order->payment) {
            $order->payment->update([
                'status' => 'success',
            ]);
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi');
    }
}
