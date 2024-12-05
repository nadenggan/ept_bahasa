<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalTes;
use App\Models\PendaftaranTes;
use App\Http\Controllers\Log;

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

        return redirect('/login/mahasiswa');
    }

    public function dashboard(Request $request)
    {
        if (!$request->session()->has('mahasiswa')) {
            return redirect('/login/mahasiswa');
        }

        // Ambil data jadwal tes
        $jadwalTes = JadwalTes::select('tanggal')->distinct()->orderBy('tanggal')->get();

        // Ambil pendaftaran tes mahasiswa
        $pendaftaranTes = PendaftaranTes::where('mahasiswa_id', $request->session()->get('mahasiswa')->id)->with('jadwalTes')->get();

        return view('mahasiswa.dashboard', compact('jadwalTes', 'pendaftaranTes'));
    }

    public function pilihTanggal(Request $request)
    {
        
        // Dapatkan ID mahasiswa dari session
        $mahasiswaId = $request->session()->get('mahasiswa')->id;

        // Mendapatkan ID jadwal_tes berdasarkan tanggal yang dipilih
        $jadwalTes = JadwalTes::where('tanggal', $request->tanggal)->first();

        if (!$jadwalTes) {
            return redirect()->back()->withErrors(['tanggal' => 'Tanggal yang dipilih tidak tersedia.']);
        }

         // Simpan pemilihan tes
         $pendaftaran = PendaftaranTes::create([
            'mahasiswa_id' => $mahasiswaId,
            'jadwal_tes_id' => $jadwalTes->id,
            'status_daftar' => 'dalam konfirmasi',
            'status_tes' => null,
            'tgl_bayar' => now(),
            'no_transaksi' => uniqid(),
            'ruangan' => null,
        ]);

        // Cek apakah pendaftaran berhasil
        if ($pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Tanggal telah dipilih, menunggu konfirmasi dari admin.');
        } else {
            return redirect()->route('mahasiswa.dashboard')->withErrors(['error' => 'Gagal menyimpan pendaftaran.']);
        }
    }
}