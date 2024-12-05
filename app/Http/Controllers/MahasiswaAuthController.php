<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.mahasiswa_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari mahasiswa berdasarkan email
        $mahasiswa = Mahasiswa::where('email', $credentials['email'])->first();

        if ($mahasiswa && Hash::check($credentials['password'], $mahasiswa->password)) {
            $request->session()->forget('admin');

            $request->session()->put('mahasiswa', $mahasiswa);
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('mahasiswa');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/mahasiswa/login');
    }

    public function dashboard(Request $request)
    {
        if (!$request->session()->has('mahasiswa')) {
            return redirect('/mahasiswa/login');
        }

        return view('mahasiswa.dashboard'); 
    }
}
