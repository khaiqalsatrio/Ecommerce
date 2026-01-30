<?php

// Namespace model Product
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'category_id', // ID kategori produk
        'name',        // Nama produk
        'slug',        // Slug (url-friendly)
        'description', // Deskripsi produk
        'price',       // Harga produk
        'stock',       // Stok produk
        'weight',      // Berat produk
        'status',      // Status produk (active / inactive)
    ];

    // Relasi: satu produk dimiliki oleh satu kategori
    public function category()
    {
        // Product belongsTo Category
        return $this->belongsTo(Category::class);
    }

    // Relasi: satu produk punya banyak gambar
    public function images()
    {
        // Product hasMany ProductImage
        return $this->hasMany(ProductImage::class);
    }

    // Relasi: satu produk punya banyak review
    public function reviews()
    {
        // Product hasMany Review
        return $this->hasMany(Review::class);
    }
}
