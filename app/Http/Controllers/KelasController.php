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
        $kelass = Kelas::orderBy('tanggal')->get()->groupBy('tanggal');
        return view('admin.jadwalkelas', compact('kelass'));
    }

    // Menambah jadwal kelas
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date', // Pastikan tanggal valid
            'ruangan' => 'required|string',
            'kuota' => 'required|integer', // Pastikan kuota juga divalidasi
        ]);

        // Kondisi jika jadwal sudah ada
        if (Kelas::where('tanggal', $request->tanggal)
            ->where('ruangan', $request->ruangan)
            ->exists()
        ) {
            return redirect()->route('admin.jadwalkelas')->withErrors(['Jadwal untuk tanggal dan ruangan ini sudah ada.']);
        }

        // Menciptakan jadwal kelas
        Kelas::create([
            'tanggal' => $request->tanggal,
            'ruangan' => $request->ruangan,
            'kuota' => $request->kuota, // Menggunakan nilai kuota dari input
        ]);

        return redirect()->route('admin.jadwalkelas')->with('success', 'Jadwal kelas berhasil ditambahkan.');
    }


    // Menghapus jadwal kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('admin.jadwalkelas')->with('success', 'Jadwal kelas berhasil dihapus.');
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
}
