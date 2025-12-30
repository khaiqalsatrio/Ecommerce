<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'total_price',
        'status',
        'payment_status',
        'snap_token',  // ← TAMBAHKAN INI untuk Midtrans
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
    ];

    // TAMBAHKAN relasi ke User (INI YANG KURANG!)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
}
