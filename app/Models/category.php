<?php

// Namespace model Category
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'name',         // Nama kategori
        'slug',         // Slug (url-friendly)
        'description'   // Deskripsi kategori
    ];

    // Relasi: satu kategori punya banyak produk
    public function products()
    {
        // Category hasMany Product
        return $this->hasMany(Product::class);
    }
}
