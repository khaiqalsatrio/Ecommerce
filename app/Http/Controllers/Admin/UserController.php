<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.data-user', compact('users'));
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        // Cegah admin menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect()
            ->route('admin.data-user')
            ->with('success', 'User berhasil dihapus');
    }
}
