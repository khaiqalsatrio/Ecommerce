<?php

// Namespace model ProductImage
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'product_id', // ID produk
        'image'       // Nama file / path / URL gambar
    ];

    // Relasi: gambar ini milik satu produk
    public function product()
    {
        // ProductImage belongsTo Product
        return $this->belongsTo(Product::class);
    }
}
