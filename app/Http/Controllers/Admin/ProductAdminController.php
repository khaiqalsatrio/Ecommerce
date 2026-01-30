<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    /**
     * LIST PRODUK
     */
    public function index()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->get();

        return view('admin.products', compact('products'));
    }


    //  * FORM TAMBAH PRODUK

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products-create', compact('categories'));
    }


    //  * SIMPAN PRODUK

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'weight'      => 'nullable|numeric|min:0',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Simpan produk
        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'weight'      => $request->weight,
            'status'      => 'active',
        ]);

        // Simpan gambar (jika ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');

                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products-edit', compact('product', 'categories'));
    }

    /**
     * UPDATE PRODUK
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'weight'      => 'nullable|numeric|min:0',
            // Hapus atau ubah jadi nullable jika status tidak ada di form
            // 'status'   => 'nullable|in:active,inactive',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'weight'      => $request->weight,
            // Hapus baris ini jika status tidak diupdate
            // 'status'   => $request->status,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * HAPUS PRODUK
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
