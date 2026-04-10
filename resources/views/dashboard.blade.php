<!DOCTYPE html>
<html>
<head>
    <title>Maulana Cipta Kreasindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">Maulana Cipta Kreasindo</a>

        <div class="d-flex gap-2">
            <a href="/dashboard" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="/upload" class="btn btn-primary btn-sm">Import</a>
            <a href="{{ url('/export') }}?nama={{ request('nama') }}&proyek={{ request('proyek') }}&tanggal={{ request('tanggal') }}" class="btn btn-success btn-sm">Excel</a>
            <a href="/export-pdf" class="btn btn-danger btn-sm">PDF</a>

            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-warning btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav> 

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between mb-3">
            <h2>Dashboard Data Absensi Karyawan</h2>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter -->
            <form method="GET" class="row mb-3">
                <div class="col">
                    <input type="text" name="nama" class="form-control" placeholder="Cari Nama" value="{{ request('nama') }}">
                </div>
                <div class="col">
                    <input type="text" name="proyek" class="form-control" placeholder="Cari Proyek" value="{{ request('proyek') }}">
                </div>
                <div class="col">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>

            <div class="mb-1 d-flex gap-2">

                <!-- IMPORT -->
                <a href="/upload" class="btn btn-primary mb-3">
                    📥 Import Excel
                </a>

                <!-- EXPORT -->
                <a href="{{ url('/export') }}?nama={{ request('nama') }}&proyek={{ request('proyek') }}&tanggal={{ request('tanggal') }}" class="btn btn-success  mb-3">
                    📤 Export Excel
                </a>
                <a href="{{ url('/export-pdf') }}?nama={{ request('nama') }}&proyek={{ request('proyek') }}&tanggal={{ request('tanggal') }}" class="btn btn-danger mb-3">
                    📄 Export PDF
                </a>
            </div>

 <div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <h6>Total Data</h6>
                <h3>{{ $totalData }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <h6>Total Upah</h6>
                <h3>Rp {{ number_format($totalUpah,0,',','.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <h6>Jumlah Tukang</h6>
                <h3>{{ $totalTukang }}</h3>
            </div>
        </div>
    </div>

</div>
            <!-- Table -->
            <table class="table table-bordered table-striped align-middle">
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
                        <td>
                            <span style="font-size: 15px;" class="badge bg-info">{{ $d->proyek }}</span>
                        </td>
                        <td>{{ $d->jam_masuk }}</td>
                        <td>{{ $d->jam_pulang }}</td>
                        <td>{{ $d->status }}</td>
                        <td>
                            <span class="badge bg-success">
                            Rp {{ number_format($d->upah_harian,0,',','.') }}
                        </span>
                        </td>
                        <td>
                            <a href="/edit/{{ $d->id }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <a href="/delete/{{ $d->id }}" 
                               onclick="return confirm('Yakin hapus?')" 
                               class="btn btn-danger btn-sm">
                               🗑️
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links() }}
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Grafik Total Upah per Proyek</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($chart->pluck('proyek')) !!};
    const data = {!! json_encode($chart->pluck('total')) !!};

    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Upah',
                data: data,
                borderWidth: 1
            }]
        }
    });
</script>
<!-- Chart End -->

<!-- Alert Otomatis Hilang -->
 <script>
    setTimeout(() => {
        let alert = document.querySelector('.alert');
        if(alert){
            alert.style.display = 'none';
        }
    }, 3000);
</script>
</body>
</html>