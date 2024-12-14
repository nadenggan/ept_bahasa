<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranKelas;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PendaftaranKelasController extends Controller
{
    // Menampilkan pendaftaran kelas
    public function index()
    {
        $pendaftaranKelas = PendaftaranKelas::with(['mahasiswa', 'kelas'])->get();
        return view('admin.pendaftaran_kelas', compact('pendaftaranKelas'));
    }    

    // Menambah pendaftaran kelas
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'jadwal_kelas_id' => 'required|exists:kelas,id',
        ]);

        // Cek jika mahasiswa sudah terdaftar pada kelas yang sama
        if (PendaftaranKelas::where('mahasiswa_id', $request->mahasiswa_id)
            ->where('jadwal_kelas_id', $request->jadwal_kelas_id)
            ->exists()) {
            return redirect()->route('pendaftaran.index')->withErrors(['Mahasiswa sudah terdaftar pada kelas ini.']);
        }

        // Cek kuota kelas
        $kelas = Kelas::find($request->jadwal_kelas_id);

        if ($kelas->kuota > 0) {
            // Mengurangi kuota kelas
            $kelas->kuota -= 1;
            $kelas->save();

            // Menambahkan pendaftaran mahasiswa pada kelas
            PendaftaranKelas::create([
                'mahasiswa_id' => $request->mahasiswa_id,
                'jadwal_kelas_id' => $request->jadwal_kelas_id,
                'status_daftar' => 'terdaftar', // Status awal
            ]);

            return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran kelas berhasil.');
        } else {
            return back()->withErrors(['kuota' => 'Kuota kelas sudah penuh.']);
        }
    }

    // Menghapus pendaftaran kelas
    public function destroy($id)
    {
        $pendaftaran = PendaftaranKelas::findOrFail($id);
        $kelas = $pendaftaran->kelas;

        // Menambah kuota kembali setelah pendaftaran dihapus
        $kelas->kuota += 1;
        $kelas->save();

        // Menghapus pendaftaran
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran kelas berhasil dihapus.');
    }

    // Menampilkan mahasiswa yang terdaftar dalam kelas tertentu
    public function showKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $pendaftaranKelas = PendaftaranKelas::with('mahasiswa')
            ->where('jadwal_kelas_id', $id)
            ->get();

        return view('admin.detail_kelas', compact('kelas', 'pendaftaranKelas'));
    }
}
