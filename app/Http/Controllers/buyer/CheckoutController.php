<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Cart kosong'
            ], 400);
        }

        return DB::transaction(function () use ($cart, $user) {

            $total = 0;
            foreach ($cart->items as $item) {
                $total += $item->qty * $item->price;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'ORD-' . now()->format('YmdHis') . rand(100, 999),
                'total_price' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid'
            ]);

            foreach ($cart->items as $item) {

                if ($item->product->stock < $item->qty) {
                    throw new \Exception('Stok produk tidak mencukupi');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->qty * $item->price
                ]);

                $item->product->decrement('stock', $item->qty);
            }

            $cart->items()->delete();

            return response()->json([
                'message' => 'Checkout berhasil',
                'order' => $order->load('items.product')
            ], 201);
        });
    }

    public function show()
    {
        $cart = auth()->user()->cart;

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->qty * $item->price;
        }

        return view('buyer.checkout', compact('cart', 'total'));
    }
}
