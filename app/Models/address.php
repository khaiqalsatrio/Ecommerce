<?php

// Namespace model Address
namespace App\Models;

// Import base Model Eloquent
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'user_id',        // ID user pemilik alamat
        'receiver_name',  // Nama penerima
        'phone',          // Nomor telepon penerima
        'address',        // Alamat lengkap
        'city',           // Kota
        'postal_code'     // Kode pos
    ];

    // Relasi: satu alamat dimiliki oleh satu user
    public function user()
    {
        // Address belongsTo User
        return $this->belongsTo(User::class);
    }
}
