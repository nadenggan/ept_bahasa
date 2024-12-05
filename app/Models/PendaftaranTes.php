<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranTes extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran';
    protected $fillable = ['mahasiswa_id', 'jadwal_tes_id', 'status_daftar', 'ruangan', 'status_tes', 'tgl_bayar', 'bukti_bayar', 'no_transaksi'];


    public function mahasiswa()
    {
        // Relasi one to many
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jadwalTes()
    {
        return $this->belongsTo(JadwalTes::class);
    }

}
