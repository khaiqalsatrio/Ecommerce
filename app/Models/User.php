<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        // Tambahkan kolom alamat
        'address',
        'city',
        'province',
        'postal_code',
    ];

    protected $hidden = ['password'];

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ❌ HAPUS RELASI INI
    // public function addresses()
    // {
    //     return $this->hasMany(Address::class);
    // }
}
