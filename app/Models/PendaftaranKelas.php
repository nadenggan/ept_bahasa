<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKelas extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_kelas';
    protected $fillable = ['mahasiswa_id', 'jadwal_kelas_id', 'tgl_kelas'];

    // Relasi ke model Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'jadwal_kelas_id');
    }
}
