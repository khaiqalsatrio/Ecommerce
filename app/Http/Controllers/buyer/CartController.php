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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->qty) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Stok tidak cukup'], 400);
            }

            return redirect()->back()->with('error', 'Stok tidak cukup');
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

        // AJAX (Buy Now)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil ditambahkan'
            ]);
        }

        // FORM BIASA (Tambah ke Keranjang)
        return redirect()
            ->route('buyer.cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    // HALAMAN CART (WAJIB VIEW)
    public function index()
    {
        $cart = Cart::with('items.product.images')
            ->where('user_id', auth()->id())
            ->first();

        return view('buyer.cart', [
            'cart' => $cart
        ]);
    }

    public function remove($id)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan');
        }

        $item = CartItem::where('id', $id)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
        }

        $item->delete();

        return redirect()
            ->back()
            ->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan');
        }

        $item = CartItem::where('id', $id)
            ->where('cart_id', $cart->id)
            ->with('product')
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Item tidak ditemukan');
        }

        // cek stok
        if ($request->qty > $item->product->stock) {
            return redirect()->back()
                ->with('error', 'Jumlah melebihi stok tersedia');
        }

        $item->update([
            'qty' => $request->qty
        ]);

        return redirect()->back()->with('success', 'Jumlah produk diperbarui');
    }
}
