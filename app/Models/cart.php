<?php

// Namespace model Cart
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = ['user_id'];

    // Relasi: satu cart punya banyak item
    public function items()
    {
        // Cart hasMany CartItem
        return $this->hasMany(CartItem::class);
    }

    // Relasi: cart dimiliki oleh satu user
    public function user()
    {
        // Cart belongsTo User
        return $this->belongsTo(User::class);
    }
}
