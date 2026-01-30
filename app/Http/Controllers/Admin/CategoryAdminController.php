<?php

// Namespace controller khusus admin
namespace App\Http\Controllers\Admin;

// Import base Controller Laravel
use App\Http\Controllers\Controller;

// Import Model Category
use App\Models\Category;

// Import Request untuk ambil data input
use Illuminate\Http\Request;

// Import Str untuk membuat slug
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    // Menampilkan halaman daftar kategori
    public function index()
    {
        // Ambil semua kategori, urutkan dari terbaru
        $categories = Category::latest()->get();

        // Kirim data ke view admin.categories
        return view('admin.categories', compact('categories'));
    }

    // Menyimpan data kategori baru
    public function store(Request $request)
    {
        // Validasi input name
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Simpan kategori ke database
        Category::create([
            'name' => $request->name,               // Nama kategori
            'slug' => Str::slug($request->name),    // Slug otomatis dari nama
        ]);

        // Redirect ke halaman index + pesan sukses
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // Menampilkan form edit kategori
    public function edit(Category $category)
    {
        // Kirim data kategori ke halaman edit
        return view('admin.categories-edit', compact('category'));
    }

    // Memperbarui data kategori
    public function update(Request $request, Category $category)
    {
        // Validasi input name
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Update data kategori
        $category->update([
            'name' => $request->name,               // Update nama
            'slug' => Str::slug($request->name),    // Update slug
        ]);

        // Redirect ke index + pesan sukses
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        // Hapus data kategori
        $category->delete();

        // Redirect ke index + pesan sukses
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
