<?php

// Namespace model OrderItem
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'order_id',   // ID order
        'product_id', // ID produk
        'qty',        // Jumlah produk
        'price',      // Harga satuan produk
        'subtotal'    // Total harga (qty × price)
    ];

    // Menonaktifkan created_at dan updated_at
    public $timestamps = false;

    // Relasi: item ini milik satu order
    public function order()
    {
        // OrderItem belongsTo Order
        return $this->belongsTo(Order::class);
    }

    // Relasi: item ini terhubung ke satu produk
    public function product()
    {
        // OrderItem belongsTo Product
        return $this->belongsTo(Product::class);
    }
}
