<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectToDashboard(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman registrasi customer.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi customer baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
            'address'               => 'nullable|string|max:500',
        ], [
            'name.required'             => 'Nama wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email ini sudah terdaftar.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        // Buat akun customer baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => UserRole::Customer,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')
            ->with('success', 'Selamat datang di TailorTrack! Akun Anda berhasil dibuat.');
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect ke dashboard sesuai role user.
     */
    private function redirectToDashboard(User $user)
    {
        return match($user->role) {
            UserRole::Admin    => redirect()->route('admin.dashboard'),
            UserRole::Tailor   => redirect()->route('tailor.dashboard'),
            UserRole::Customer => redirect()->route('customer.dashboard'),
        };
    }
}
