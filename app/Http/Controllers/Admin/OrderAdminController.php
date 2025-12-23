<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderAdminController extends Controller
{
    public function index()
    {
        return Order::with('items.product', 'payment')->get();
    }

    public function verify($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => 'paid',
            'status' => 'paid'
        ]);

        if ($order->payment) {
            $order->payment->update([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran dikonfirmasi'
        ]);
    }
}
