<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4>Dashboard Data Absensi Tukang</h4>
        </div>

        <div class="card-body">
            <form action="/logout" method="POST" class="mb-3">
                 @csrf
                <button class="btn btn-danger">Logout</button>
            </form>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter -->
            <form method="GET" class="row mb-3">
                <div class="col">
                    <input type="text" name="nama" class="form-control" placeholder="Cari Nama">
                </div>
                <div class="col">
                    <input type="text" name="proyek" class="form-control" placeholder="Cari Proyek">
                </div>
                <div class="col">
                    <input type="date" name="tanggal" class="form-control">
                </div>
                <div class="col">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>
            <a href="/export" class="btn btn-success mb-3">
                Export Excel
            </a>
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Proyek</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Status</th>
                        <th>Upah</th>
                        <th>Aksi</th>
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
                        <td>
                            <a href="/delete/{{ $d->id }}" 
                               onclick="return confirm('Yakin hapus?')" 
                               class="btn btn-danger btn-sm">
                               Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $data->links() }}

        </div>
    </div>

</div>

</body>
</html>