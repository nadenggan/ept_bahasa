<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use App\Models\JadwalTes;
use App\Models\PendaftaranTes;
use App\Models\Kelas;
use App\Models\PendaftaranKelas;
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


    // Menampilkan halaman Dashboard
    public function dashboard()
    {
        return view('mahasiswa.dashboard');
    }
    // Menampilkan halaman daftar EPT mahasiswa
    public function ept(Request $request)
    {
        if (!$request->session()->has('mahasiswa')) {
            return redirect('/login/mahasiswa');
        }

        // Mengambil data jadwal tes
        $jadwalTes = JadwalTes::select('tanggal')->distinct()->orderBy('tanggal')->get();

        // Mengambil data pendaftaran tes mahasiswa
        $pendaftaranTes = PendaftaranTes::where('mahasiswa_id', $request->session()->get('mahasiswa')->id)->with('jadwalTes')->latest() 
        ->first();;

        return view('mahasiswa.ept', compact('jadwalTes', 'pendaftaranTes'));
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
            return redirect()->route('mahasiswa.ept')->with('success', 'Tanggal telah dipilih, lakukan pembayaran Anda!');
        } else {
            return redirect()->route('mahasiswa.ept')->withErrors(['error' => 'Gagal menyimpan pendaftaran.']);
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

        return redirect()->route('mahasiswa.ept')->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }

    // Menampilkan form pendaftaran kelas
    public function daftarKelasForm(Request $request)
    {
        // Cek apakah mahasiswa sudah login
        if (!$request->session()->has('mahasiswa')) {
            return redirect('/login/mahasiswa');
        }

        // Ambil data kelas yang tersedia
        $kelas = Kelas::where('kuota', '>', 0)->get();

        return view('mahasiswa.daftar_kelas', compact('kelas'));
    }

    // Menyimpan pendaftaran kelas
public function daftarKelas(Request $request)
{
    // Validasi input
    $request->validate([
        'jadwal_kelas_id' => 'required|exists:kelas,id',
    ]);

    // Ambil kelas yang dipilih
    $kelas = Kelas::findOrFail($request->jadwal_kelas_id);

    // Cek kuota kelas
    if ($kelas->kuota <= 0) {
        return back()->withErrors(['Kelas sudah penuh.']);
    }

    // Simpan pendaftaran kelas
    PendaftaranKelas::create([
        'mahasiswa_id' => $request->session()->get('mahasiswa')->id,
        'jadwal_kelas_id' => $request->jadwal_kelas_id,
        'status_daftar' => 'menunggu',
    ]);

    // Kurangi kuota kelas
    $kelas->decrement('kuota');

    return redirect()->route('mahasiswa.daftarKelasForm')->with('success', 'Pendaftaran kelas berhasil!');
}
}