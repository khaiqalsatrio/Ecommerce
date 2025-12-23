<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->qty) {
            return response()->json(['message' => 'Stok tidak cukup'], 400);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->increment('qty', $request->qty);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $request->qty,
                'price' => $product->price
            ]);
        }

        return response()->json(['message' => 'Berhasil ditambahkan']);
    }

    public function index()
    {
        return auth()->user()
            ->cart
            ->items()
            ->with('product.images')
            ->get();
    }
}
