<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTes extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'ruangan', 'kapasitas', 'kuota'];
}
