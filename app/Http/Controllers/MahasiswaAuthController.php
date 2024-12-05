<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalTes;
use App\Models\PendaftaranTes;
use App\Http\Controllers\Log;
use Carbon\Carbon;

class MahasiswaAuthController extends Controller
{
    // Menampilkan form login mahasiswa
    public function showLoginForm()
    {
        return view('auth.mahasiswa_login');
    }

    // Validasi mahasiswa login
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

    // Logout mahasiswa
    public function logout(Request $request)
    {
        $request->session()->forget('mahasiswa');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/mahasiswa');
    }

    // Menampilkan dashboard mahasiswa
    public function dashboard(Request $request)
    {
        if (!$request->session()->has('mahasiswa')) {
            return redirect('/login/mahasiswa');
        }

        // Mengambil data jadwal tes
        $jadwalTes = JadwalTes::select('tanggal')->distinct()->orderBy('tanggal')->get();

        // Mengambil data pendaftaran tes mahasiswa
        $pendaftaranTes = PendaftaranTes::where('mahasiswa_id', $request->session()->get('mahasiswa')->id)->with('jadwalTes')->get();

        return view('mahasiswa.dashboard', compact('jadwalTes', 'pendaftaranTes'));
    }

    // Memilih tanggal tes EPT
    public function pilihTanggal(Request $request)
    {
        $mahasiswaId = $request->session()->get('mahasiswa')->id;

        // Mendapatkan ID jadwal_tes berdasarkan tanggal yang dipilih
        $jadwalTes = JadwalTes::where('tanggal', $request->tanggal)->first();

        // Kondisi jika jadwal tidak tersedia
        if (!$jadwalTes) {
            return redirect()->back()->withErrors(['tanggal' => 'Tanggal yang dipilih tidak tersedia.']);
        }

        // Menyimpan pemilihan tes
        $pendaftaran = PendaftaranTes::create([
            'mahasiswa_id' => $mahasiswaId,
            'jadwal_tes_id' => $jadwalTes->id,
            'status_daftar' => 'belum bayar',
            'status_tes' => null,
            'tgl_bayar' => null,
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

    // Komfirmasi pembayaran oleh mahasiswa
    public function konfirmasiBayar(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pendaftaran = PendaftaranTes::findOrFail($id);

        // Simpan file ke storage/public/bukti_pembayaran
        $filePath = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');

        // Update tabel pendaftaran
        $pendaftaran->update([
            'bukti_bayar' => $filePath,
            'status_daftar' => 'Dalam Konfirmasi', // Status diperbarui
            'tgl_bayar' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }

}