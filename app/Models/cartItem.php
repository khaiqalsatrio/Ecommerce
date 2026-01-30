<?php

// Namespace model CartItem
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Menonaktifkan created_at dan updated_at
    public $timestamps = false;

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'cart_id',     // ID cart
        'product_id',  // ID produk
        'qty',         // Jumlah produk
        'price'        // Harga produk saat ditambahkan ke cart
    ];

    // Relasi: cart item terhubung ke satu produk
    public function product()
    {
        // CartItem belongsTo Product
        return $this->belongsTo(Product::class);
    }
}
