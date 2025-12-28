<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    /**
     * Display all orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])
            ->latest();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        // PASTIKAN INI:
        return view('admin.orders', compact('orders'));  
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        // Validasi: hanya bisa update jika payment sudah paid
        if ($order->payment_status !== 'paid' && $request->status !== 'cancelled') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status. Pembayaran belum lunas.');
        }

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }

    /**
     * Show order detail
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cancel order (optional)
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Hanya bisa cancel jika belum paid atau masih pending
        if ($order->payment_status === 'paid' && in_array($order->status, ['shipped', 'completed'])) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan order yang sudah dikirim/selesai.');
        }

        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed'
        ]);

        // Kembalikan stok
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->qty);
        }

        return redirect()->back()->with('success', 'Order berhasil dibatalkan dan stok dikembalikan.');
    }
}
