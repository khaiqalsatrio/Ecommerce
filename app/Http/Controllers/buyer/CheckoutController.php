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

        // Validasi cart
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong'
            ], 400);
        }

        // ✅ VALIDASI ALAMAT
        if (!$user->address || !$user->city || !$user->province || !$user->postal_code) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon lengkapi alamat pengiriman terlebih dahulu'
            ], 400);
        }

        try {
            return DB::transaction(function () use ($cart, $user) {

                // Hitung total
                $total = $cart->items->sum(fn($item) => $item->qty * $item->price);

                // =========================
                // BUAT ORDER + SIMPAN ALAMAT
                // =========================
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_code' => 'ORD-' . now()->format('YmdHis') . random_int(100, 999),
                    'total_price' => $total,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    // ✅ SIMPAN ALAMAT KE ORDER
                    'shipping_address' => $user->address,
                    'shipping_city' => $user->city,
                    'shipping_province' => $user->province,
                    'shipping_postal_code' => $user->postal_code,
                ]);

                $itemDetails = [];

                // ... sisa code sama seperti sebelumnya
                foreach ($cart->items as $item) {
                    $product = $item->product;

                    if (!$product || $product->stock < $item->qty) {
                        throw new \Exception('Stok produk tidak mencukupi');
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'subtotal' => $item->qty * $item->price
                    ]);

                    $itemDetails[] = [
                        'id' => 'product-' . $product->id,
                        'price' => (int) $item->price,
                        'quantity' => $item->qty,
                        'name' => $product->name,
                    ];

                    $product->decrement('stock', $item->qty);
                }

                $cart->items()->delete();

                // Midtrans config
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = false;
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_code,
                        'gross_amount' => (int) $order->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                    ],
                    'item_details' => $itemDetails,
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $order->update([
                    'snap_token' => $snapToken
                ]);

                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_code' => $order->order_code,
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Checkout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('buyer.cart.index')
                ->with('error', 'Cart kosong');
        }

        $total = $cart->items->sum(fn($item) => $item->qty * $item->price);

        // Langsung ambil data user (alamat ada di tabel users)
        $address = $user;

        // ✅ UBAH INI - sesuaikan dengan struktur folder
        return view('buyer.checkout', [  // bukan 'buyer.checkout.index'
            'cart' => $cart,
            'total' => $total,
            'address' => $address
        ]);
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
