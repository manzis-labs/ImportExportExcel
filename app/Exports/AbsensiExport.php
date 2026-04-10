<?php

namespace App\Exports;

use App\Models\AbsensiTukang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
        {
            $this->data = $data;
        }

        public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        return [
            $row->tanggal,
            $row->nama_tukang,
            $row->jabatan,
            $row->proyek,
            $row->jam_masuk,
            $row->jam_pulang,
            $row->status,
            $row->upah_harian,
        ];
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