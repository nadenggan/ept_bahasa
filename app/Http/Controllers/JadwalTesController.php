<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalTes;
use App\Models\PendaftaranTes;
use Illuminate\Support\Facades\Log;


class JadwalTesController extends Controller
{
    // Menampilkan halaman dashboard admin (jadwal tes ept)
    public function index()
    {
        $jadwals = JadwalTes::orderBy('tanggal')->get()->groupBy('tanggal');

        return view('admin.index', compact('jadwals'));
    }

    // Menambah jadwal tes EPT
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        // Kondisi jika jadwal sudah ada
        if (JadwalTes::where('tanggal', $request->tanggal)->exists()) {
            return redirect()->route('jadwal.index')->withErrors(['Jadwal untuk tanggal ini sudah ada.']);
        }

        // Menciptakan jadwal beserta 4 ruangan, kapasitas, dan kuota
        $ruangan = ['Ruangan 1', 'Ruangan 2', 'Ruangan 3', 'Ruangan 4'];
        foreach ($ruangan as $namaRuangan) {
            JadwalTes::create([
                'tanggal' => $request->tanggal,
                'ruangan' => $namaRuangan,
                'kapasitas' => 30,
                'kuota' => 30,
            ]);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Menghapus jadwal tes EPT
    public function destroy($tanggal)
    {
        JadwalTes::where('tanggal', $tanggal)->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal untuk tanggal tersebut berhasil dihapus.');
    }

    // Menampilkan antrian pendaftaran tes EPT
    public function showPendaftaran()
    {
        $pendaftaranTes = PendaftaranTes::with(['mahasiswa', 'jadwalTes'])->get();
        return view('admin.pendaftaran_tes', compact('pendaftaranTes'));
    }

    // Menentukan ruangan untuk tes EPT
    public function tentukanRuangan(Request $request, $id)
    {
        $pendaftaran = PendaftaranTes::find($id);

        // Cek kapasitas ruangan
        $ruangan = $request->ruangan;
        $kapasitas = JadwalTes::where('ruangan', $ruangan)
            ->where('tanggal', $pendaftaran->jadwalTes->tanggal)
            ->first();

        // Kondisi kuota yang tersedia
        if ($kapasitas && $kapasitas->kuota > 0) {
            // Mengurangi kuota
            $kapasitas->kuota -= 1;
            $kapasitas->save();

            //Log::info('Sebelum update: ', ['pendaftaran' => $pendaftaran]);

            // Updata value ruangan dan status_daftar pada tabel mahasiswa
            $pendaftaran->update([
                'ruangan' => $request->ruangan,
                'status_daftar' => 'diterima',
            ]);

            // Log::info('Setelah update: ', ['pendaftaran' => $pendaftaran]);

            return redirect()->route('admin.pendaftaran_tes')->with('success', 'Ruangan berhasil ditentukan untuk mahasiswa.');
        } else {
            return back()->withErrors(['ruangan' => 'Ruangan tidak tersedia.']);
        }
    }

    // Menampilkan data mahasiswa yang akan tes EPT
    public function showTerjadwal()
    {
        $terjadwal = PendaftaranTes::with(['mahasiswa', 'jadwalTes'])
            ->whereNotNull('ruangan')
            ->where('status_daftar', 'diterima')
            ->get();

        return view('admin.terjadwal', compact('terjadwal'));
    }

    // Update status_tes mahasiswa
    public function updateStatusTes(Request $request, $id)
    {
        $pendaftaran = PendaftaranTes::findOrFail($id);

        $request->validate([
            'status_tes' => 'required|in:Belum Tes,Sudah Tes',
        ]);

        $pendaftaran->update([
            'status_tes' => $request->status_tes,
        ]);

        return redirect()->route('admin.pendaftaran.terjadwal')->with('success', 'Status tes berhasil diperbarui.');
    }

    // Verifikasi pembayaran
    public function verifikasiBayar($id)
    {
        $pendaftaran = PendaftaranTes::findOrFail($id);

        $pendaftaran->update([
            'status_daftar' => 'Diterima', // Perbarui status
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');

    }

    public function batalVerifikasi($id)
    {
        // Cari data pendaftaran berdasarkan ID
        $pendaftaran = PendaftaranTes::find($id);

        // Perbarui status pembayaran ke 'Belum Terverifikasi'
        $pendaftaran->status_daftar = 'Ditolak';
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Verifikasi pembayaran berhasil dibatalkan.');
    }
}
