<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Jika admin sudah login, arahkan ke dashboard
        if ($request->session()->has('admin')) {
            return redirect('/dashboard');
        }

        // Jika belum login, tampilkan form login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari admin berdasarkan email
        $admin = Admin::where('email', $credentials['email'])->first();

        // Periksa apakah admin ditemukan dan password cocok
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Simpan data admin di session
            $request->session()->put('admin', $admin);

            return redirect('/dashboard');
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function dashboard(Request $request)
    {
        // Periksa apakah admin sudah login
        if (!$request->session()->has('admin')) {
            return redirect('/login');
        }

        // Tampilkan halaman dashboard
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        // Hapus session admin
        $request->session()->forget('admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
