<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between mb-3">
            <h2>Dashboard Data Absensi Karyawan Maulana Cipta Kreasindo</h2>
            <form action="/logout" method="POST" class="mb-3">
                 @csrf
                <button class="btn btn-danger">Logout</button>
            </form>
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

            <div class="mb-3 d-flex gap-2">

                <!-- IMPORT -->
                <a href="/upload" class="btn btn-primary">
                    📥 Import Excel
                </a>

                <!-- EXPORT -->
                <a href="/export" class="btn btn-success">
                    📤 Export Excel
                </a>

            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div class="text-center" style="background: #4CAF50; color: white; padding: 15px; border-radius: 10px;">
                    <h3>Total Data</h3>
                    <p class="fs-5 fw-bold mb-0">{{ $totalData }}</p>
                </div>

                <div class="text-center" style="background: #2196F3; color: white; padding: 15px; border-radius: 10px;">
                    <h3>Total Upah</h3>
                    <p class="fs-5 fw-bold mb-0">Rp {{ number_format($totalUpah, 0, ',', '.') }}</p>
                </div>

                <div class="text-center" style="background: #FF9800; color: white; padding: 15px; border-radius: 10px;">
                    <h3>Jumlah Karyawan</h3>
                    <p class="fs-4 fw-bold mb-0">{{ $totalTukang }}</p>
                </div>
            </div>
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
                            <a href="/edit/{{ $d->id }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
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
            {{ $data->links() }}
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Grafik Total Upah per Proyek</h5>
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