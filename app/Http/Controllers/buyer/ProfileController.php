<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'password'     => 'nullable|min:6|confirmed',

            // VALIDASI ALAMAT
            'address'      => 'nullable|string',
            'city'         => 'nullable|string|max:100',
            'province'     => 'nullable|string|max:100',
            'postal_code'  => 'nullable|string|max:10',
        ]);

        // UPDATE DATA UTAMA
        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,

            // DATA ALAMAT
            'address'     => $request->address,
            'city'        => $request->city,
            'province'    => $request->province,
            'postal_code' => $request->postal_code,
        ]);

        // UPDATE PASSWORD (JIKA DIISI)
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
