<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Laporan Absensi</h2>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Proyek</th>
            <th>Masuk</th>
            <th>Pulang</th>
            <th>Status</th>
            <th>Upah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->tanggal }}</td>
            <td>{{ $d->nama_tukang }}</td>
            <td>{{ $d->jabatan }}</td>
            <td>{{ $d->proyek }}</td>
            <td>{{ $d->jam_masuk }}</td>
            <td>{{ $d->jam_pulang }}</td>
            <td>{{ $d->status }}</td>
            <td>{{ $d->upah_harian }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>