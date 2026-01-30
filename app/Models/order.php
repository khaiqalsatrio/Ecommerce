<?php

// Namespace model Order
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'user_id',                // ID user pemilik order
        'order_code',             // Kode unik order
        'total_price',            // Total harga order
        'status',                 // Status order (pending, process, done, dll)
        'payment_status',         // Status pembayaran (pending, paid, failed)
        'snap_token',             // Token Midtrans untuk proses pembayaran
        'shipping_address',       // Alamat pengiriman
        'shipping_city',          // Kota pengiriman
        'shipping_province',      // Provinsi pengiriman
        'shipping_postal_code',   // Kode pos pengiriman
    ];

    // Relasi: satu order dimiliki oleh satu user
    public function user()
    {
        // Order belongsTo User
        return $this->belongsTo(User::class);
    }

    // Relasi: satu order punya banyak item
    public function items()
    {
        // Order hasMany OrderItem
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: satu order punya satu data pembayaran
    public function payment()
    {
        // Order hasOne Payment
        return $this->hasOne(Payment::class);
    }

    // Relasi: satu order punya satu data pengiriman
    public function shipment()
    {
        // Order hasOne Shipment
        return $this->hasOne(Shipment::class);
    }
}
