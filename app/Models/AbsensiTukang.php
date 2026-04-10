<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiTukang extends Model
{
    protected $table = 'absensi_tukang';
    protected $fillable = [
    'tanggal',
    'nama_tukang',
    'jabatan',
    'proyek',
    'jam_masuk',
    'jam_pulang',
    'status',
    'upah_harian'
];
}
