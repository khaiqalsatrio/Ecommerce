<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // SANDBOX VERSION
    public function process(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong'
            ], 400);
        }

        try {
            return DB::transaction(function () use ($cart, $user) {

                $total = 0;
                foreach ($cart->items as $item) {
                    $total += $item->qty * $item->price;
                }

                // Buat order
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_code' => 'ORD-' . now()->format('YmdHis') . rand(100, 999),
                    'total_price' => $total,
                    'status' => 'pending',
                    'payment_status' => 'unpaid'
                ]);

                // Siapkan item details untuk Midtrans
                $itemDetails = [];

                foreach ($cart->items as $item) {

                    if ($item->product->stock < $item->qty) {
                        throw new \Exception('Stok produk ' . $item->product->name . ' tidak mencukupi');
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'subtotal' => $item->qty * $item->price
                    ]);

                    // Tambahkan ke item details Midtrans
                    $itemDetails[] = array(
                        'id' => 'product-' . $item->product_id,
                        'price' => (int) $item->price,
                        'quantity' => $item->qty,
                        'name' => $item->product->name ?? 'Product',
                    );

                    $item->product->decrement('stock', $item->qty);
                }

                // Hapus cart setelah order dibuat
                $cart->items()->delete();

                // =========================
                // KONFIGURASI MIDTRANS (SANDBOX)
                // =========================
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = false; // SANDBOX MODE
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                // =========================
                // PARAMETER TRANSAKSI
                // =========================
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order->order_code,
                        'gross_amount' => (int) $order->total_price,
                    ),
                    'customer_details' => array(
                        'first_name' => $user->name,
                        'email' => $user->email,
                    ),
                    'item_details' => $itemDetails,
                );

                // Generate Snap Token
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Simpan snap token ke order
                $order->update(['snap_token' => $snapToken]);

                // Return JSON untuk AJAX request
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_code' => $order->order_code,
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout gagal: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Cart kosong');
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->qty * $item->price;
        }

        return view('buyer.checkout', compact('cart', 'total'));
    }

    /**
     * Halaman sukses setelah payment
     */
    public function success($orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('buyer.order-success', compact('order'));
    }

    /**
     * Halaman pending payment
     */
    public function pending($orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('buyer.order-pending', compact('order'));
    }

    /**
     * Callback Midtrans (WEBHOOK) - SANDBOX
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            // Cari order berdasarkan order_code
            $order = Order::where('order_code', $request->order_id)->first();

            if ($order) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing'
                    ]);
                } else if ($request->transaction_status == 'pending') {
                    $order->update([
                        'payment_status' => 'pending',
                        'status' => 'pending'
                    ]);
                } else if ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $order->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled'
                    ]);

                    // Kembalikan stok produk
                    foreach ($order->items as $item) {
                        $item->product->increment('stock', $item->qty);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
