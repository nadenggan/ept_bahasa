<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\PendaftaranKelas;

class KelasController extends Controller
{
 // Menampilkan jadwal kelas
 public function index()
 {
     $jadwals = Kelas::orderBy('tanggal')->get()->groupBy('tanggal');
     return view('admin.index', compact('jadwals'));
 }

 // Menambah jadwal kelas
 public function store(Request $request)
 {
     $request->validate([
         'tanggal' => 'required|date',
         'ruangan' => 'required|string',
     ]);

     // Kondisi jika jadwal sudah ada
     if (Kelas::where('tanggal', $request->tanggal)
         ->where('ruangan', $request->ruangan)
         ->exists()) {
         return redirect()->route('jadwal.index')->withErrors(['Jadwal untuk tanggal dan ruangan ini sudah ada.']);
     }

     // Menciptakan jadwal kelas
     Kelas::create([
         'tanggal' => $request->tanggal,
         'ruangan' => $request->ruangan,
         'kuota' => 30, // Kuota yang tersedia
     ]);

     return redirect()->route('jadwal.index')->with('success', 'Jadwal kelas berhasil ditambahkan.');
 }

 // Menghapus jadwal kelas
 public function destroy($id)
 {
     $kelas = Kelas::findOrFail($id);
     $kelas->delete();
     return redirect()->route('jadwal.index')->with('success', 'Jadwal kelas berhasil dihapus.');
 }

 // Menampilkan antrian pendaftaran kelas
 public function showPendaftaran()
 {
     $pendaftaranKelas = PendaftaranKelas::with(['mahasiswa', 'kelas'])->get();
     return view('admin.pendaftaran_kelas', compact('pendaftaranKelas'));
 }

 // Menentukan kelas untuk mahasiswa
 public function tentukanKelas(Request $request, $id)
 {
     $pendaftaran = PendaftaranKelas::findOrFail($id);

     // Cek kuota kelas
     $kelas = Kelas::where('id', $pendaftaran->jadwal_kelas_id)->first();

     // Kondisi kuota yang tersedia
     if ($kelas && $kelas->kuota > 0) {
         // Mengurangi kuota
         $kelas->kuota -= 1;
         $kelas->save();

         // Update status pendaftaran mahasiswa
         $pendaftaran->update([
             'status_daftar' => 'diterima',
             'tgl_kelas' => $request->tgl_kelas ?? $pendaftaran->tgl_kelas,
         ]);

         return redirect()->route('admin.pendaftaran_kelas')->with('success', 'Kelas berhasil ditentukan untuk mahasiswa.');
     } else {
         return back()->withErrors(['ruangan' => 'Kuota kelas tidak tersedia.']);
     }
 }

 // Menampilkan mahasiswa yang terdaftar di kelas
 public function showTerjadwal()
 {
     $terjadwal = PendaftaranKelas::with(['mahasiswa', 'kelas'])
         ->whereNotNull('tgl_kelas')
         ->where('status_daftar', 'diterima')
         ->get();

     return view('admin.terjadwal', compact('terjadwal'));
 }

 // Update status pendaftaran mahasiswa
 public function updateStatus(Request $request, $id)
 {
     $pendaftaran = PendaftaranKelas::findOrFail($id);

     $request->validate([
         'status_daftar' => 'required|in:diterima,ditolak',
     ]);

     $pendaftaran->update([
         'status_daftar' => $request->status_daftar,
     ]);

     return redirect()->route('admin.pendaftaran_kelas')->with('success', 'Status pendaftaran berhasil diperbarui.');
 }
}