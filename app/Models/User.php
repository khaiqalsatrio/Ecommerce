<?php

// Namespace model User
namespace App\Models;

// Trait untuk factory (testing / seeder)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Base class untuk autentikasi user
use Illuminate\Foundation\Auth\User as Authenticatable;

// Trait untuk notifikasi
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'name',         // Nama user
        'email',        // Email user
        'password',     // Password (terenkripsi)
        'phone',        // Nomor telepon
        'role',         // Role user (admin / customer)
        'status',       // Status user (active / inactive)

        // Data alamat utama user
        'address',      // Alamat lengkap
        'city',         // Kota
        'province',     // Provinsi
        'postal_code',  // Kode pos
    ];

    // Field yang disembunyikan saat response
    protected $hidden = [
        'password'      // Menyembunyikan password
    ];

    // Relasi: satu user punya satu cart
    public function cart()
    {
        // User hasOne Cart
        return $this->hasOne(Cart::class);
    }

    // Relasi: satu user punya banyak order
    public function orders()
    {
        // User hasMany Order
        return $this->hasMany(Order::class);
    }

    // Relasi addresses dihapus karena alamat disimpan langsung di tabel users
}
