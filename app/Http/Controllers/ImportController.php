<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\AbsensiTukang;
use Illuminate\Support\Facades\DB;

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

        return redirect('/dashboard')->with('success', 'Data berhasil diimport!');
    }

public function preview(Request $request)
{
    $file = $request->file('file');

    $spreadsheet = IOFactory::load($file);
    $data = $spreadsheet->getActiveSheet()->toArray();

    $errors = [];
    $warnings = [];
    $preview = [];

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

        $exists = AbsensiTukang::where('tanggal', $row[0])
            ->where('nama_tukang', $row[1])
            ->where('proyek', $row[3])
            ->exists();
            $isError = false;
        if ($exists) {
            $warnings[] = "Baris " . ($i+1) . " data duplikat (sudah ada di database)";
            }
        $preview[] = [
            'no' => $i + 1,
            'tanggal' => $row[0],
            'nama_tukang' => $row[1],
            'jabatan' => $row[2],
            'proyek' => $row[3],
            'jam_masuk' => $row[4],
            'jam_pulang' => $row[5],
            'status' => $row[6],
            'upah_harian' => $row[7],
            'duplicate' => $exists,
            'is_error' => $isError
        ];
    }

    session(['excel_data' => $data]);

    return view('preview', compact('preview', 'errors', 'warnings'));
}

    public function import()
{
    $data = session('excel_data');

    $inserted = 0;
    $skipped = 0;

    foreach ($data as $i => $row) {
        if ($i == 0) continue;

        $exists = AbsensiTukang::where('tanggal', $row[0])
            ->where('nama_tukang', $row[1])
            ->where('proyek', $row[3])
            ->exists();

        if (!$exists) {
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

            $inserted++;
        } else {
            $skipped++;
        }
    }

    return redirect('/dashboard')->with(
        'success',
        "Import selesai: $inserted data masuk, $skipped data duplikat dilewati"
    );
}

public function export(Request $request)
{
    $query = AbsensiTukang::query();

    if ($request->nama) {
        $query->where('nama_tukang', 'like', '%' . $request->nama . '%');
    }

    if ($request->proyek) {
        $query->where('proyek', 'like', '%' . $request->proyek . '%');
    }

    if ($request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    $data = $query->get();

    return Excel::download(new AbsensiExport($data), 'Absensi.xlsx');
}

    public function index(Request $request)
{
    $query = AbsensiTukang::query();

    if ($request->nama) {
        $query->where('nama_tukang', 'like', '%' . $request->nama . '%');
    }

    if ($request->proyek) {
        $query->where('proyek', 'like', '%' . $request->proyek . '%');
    }

    if ($request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    $filteredQuery = clone $query;

    $data = $query->paginate(10)->withQueryString();

    $filteredData = $filteredQuery->get();

    $totalData = $filteredData->count();
    $totalUpah = $filteredData->sum('upah_harian');
    $totalTukang = $filteredData->unique('nama_tukang')->count();

    $chart = (clone $filteredQuery)
        ->select('proyek', DB::raw('SUM(upah_harian) as total'))
        ->groupBy('proyek')
        ->get();

    return view('dashboard', compact(
        'data',
        'totalData',
        'totalUpah',
        'totalTukang',
        'chart'
    ));
}

    public function edit($id)
    {
        $data = AbsensiTukang::findOrFail($id);
        return view('edit', compact('data'));
    }   

    public function update(Request $request, $id)
    {
        $data = AbsensiTukang::findOrFail($id);

        $data->update([
            'nama_tukang' => $request->nama_tukang,
            'jabatan' => $request->jabatan,
            'proyek' => $request->proyek,
            'upah_harian' => $request->upah_harian,
        ]);

        return redirect('/dashboard')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
    AbsensiTukang::findOrFail($id)->delete();
    return back()->with('success', 'Data berhasil dihapus');
    }
}