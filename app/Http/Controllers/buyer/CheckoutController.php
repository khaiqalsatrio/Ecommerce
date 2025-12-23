<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = auth()->user()->cart;
        $total = 0;

        foreach ($cart->items as $item) {
            $total += $item->qty * $item->price;
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_code' => 'ORD-' . time(),
            'total_price' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        foreach ($cart->items as $item) {
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

        return response()->json($order);
    }
}
