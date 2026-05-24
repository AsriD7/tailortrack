<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Tampilkan daftar semua user (customer dan penjahit).
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', UserRole::Admin->value);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->with('tailorProfile')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan detail satu user.
     */
    public function show(User $user)
    {
        $user->load(['tailorProfile', 'customerOrders', 'tailorOrders']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Hapus akun user (kecuali admin sendiri).
     */
    public function destroy(User $user)
    {
        // Jangan izinkan admin hapus akun sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Jangan izinkan hapus admin lain
        if ($user->role === UserRole::Admin) {
            return back()->with('error', 'Akun admin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$user->name} berhasil dihapus.");
    }
}
