<?php

namespace App\Exports;

use App\Models\AbsensiTukang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return AbsensiTukang::select(
            'tanggal',
            'nama_tukang',
            'jabatan',
            'proyek',
            'jam_masuk',
            'jam_pulang',
            'status',
            'upah_harian'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'Jabatan',
            'Proyek',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
            'Upah'
        ];
    }
}