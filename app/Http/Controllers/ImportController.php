<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\AbsensiTukang;

class ImportController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $index => $row) {
            if ($index == 0) continue; // skip header

            AbsensiTukang::create([
                'tanggal' => $row[0],
                'nama_tukang' => $row[1],
                'jabatan' => $row[2],
                'proyek' => $row[3],
                'jam_masuk' => $row[4] ?: null,
                'jam_pulang' => $row[5] ?: null,
                'status' => $row[6],
                'upah_harian' => $row[7],
            ]);
        }

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function preview(Request $request)
    {
    $file = $request->file('file');

    $spreadsheet = IOFactory::load($file);
    $data = $spreadsheet->getActiveSheet()->toArray();

    $errors = [];

    foreach ($data as $i => $row) {
    if ($i == 0) continue;

    if (empty($row[0])) {
        $errors[] = "Baris " . ($i+1) . " tanggal kosong";
    }

    if (!strtotime($row[0])) {
        $errors[] = "Baris " . ($i+1) . " format tanggal salah";
    }

    if (!is_numeric($row[7])) {
        $errors[] = "Baris " . ($i+1) . " upah harus angka";
    }
}

    session(['excel_data' => $data]);

    return view('preview', compact('data', 'errors'));
    }

    public function import()
    {
    $data = session('excel_data');

    foreach ($data as $i => $row) {
        if ($i == 0) continue;

        AbsensiTukang::create([
            'tanggal' => $row[0],
            'nama_tukang' => $row[1],
            'jabatan' => $row[2],
            'proyek' => $row[3],
            'jam_masuk' => $row[4] ?: null,
            'jam_pulang' => $row[5] ?: null,
            'status' => $row[6],
            'upah_harian' => $row[7],
        ]);
    }

    return redirect('/')->with('success', 'Data berhasil diimport!');
    }

    public function export()
{
    return Excel::download(new AbsensiExport, 'laporan_absensi.xlsx');
}

    public function index(Request $request)
{
    $query = AbsensiTukang::query();

    // filter nama
    if ($request->nama) {
        $query->where('nama_tukang', 'like', '%' . $request->nama . '%');
    }

    // filter proyek
    if ($request->proyek) {
        $query->where('proyek', 'like', '%' . $request->proyek . '%');
    }

    // filter tanggal
    if ($request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    // ambil data
    $data = $query->latest()->paginate(10);

    $totalData = $query->count();
    $totalUpah = $query->sum('upah_harian');
    $totalTukang = $query->distinct('nama_tukang')->count('nama_tukang');

    return view('dashboard', compact(
        'data',
        'totalData',
        'totalUpah',
        'totalTukang'
    ));
}

    public function delete($id)
    {
    AbsensiTukang::findOrFail($id)->delete();
    return back()->with('success', 'Data berhasil dihapus');
    }
}