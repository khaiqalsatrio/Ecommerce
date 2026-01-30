<?php

// Namespace model Payment
namespace App\Models;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'order_id',        // ID order terkait
        'payment_method',  // Metode pembayaran (transfer, midtrans, dll)
        'payment_proof',   // Bukti pembayaran (file / path / url)
        'payment_date',    // Tanggal pembayaran
        'status'           // Status pembayaran (pending, success, failed)
    ];

    // Relasi: satu pembayaran milik satu order
    public function order()
    {
        // Payment belongsTo Order
        return $this->belongsTo(Order::class);
    }
}
