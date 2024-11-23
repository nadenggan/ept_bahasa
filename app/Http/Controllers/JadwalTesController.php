<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalTes;

class JadwalTesController extends Controller
{
    public function index()
    {
        $jadwals = JadwalTes::orderBy('tanggal')->get()->groupBy('tanggal');

        return view('jadwal.index', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);


        if (JadwalTes::where('tanggal', $request->tanggal)->exists()) {
            return redirect()->route('jadwal.index')->withErrors(['Jadwal untuk tanggal ini sudah ada.']);
        }

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

    public function destroy($tanggal)
    {
        JadwalTes::where('tanggal', $tanggal)->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal untuk tanggal tersebut berhasil dihapus.');
    }
}
