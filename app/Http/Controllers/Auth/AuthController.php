<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        return redirect('/login')->with('success', 'Register berhasil');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah');
        }

        $request->session()->regenerate(); 

        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/'); 
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
