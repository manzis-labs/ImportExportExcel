<!DOCTYPE html>
<html>
<head>
    <title>Maulana Cipta Kreasindo</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style -->
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;   
        top: 0;
        left: 0;
        overflow-y: auto;
        }

        .menu-item {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .menu-item:hover {
            background-color: #0d6efd;
            transform: translateX(5px);
        }

        .content {
            background: #f8f9fa;
            min-height: 100vh;
            width: 100%;
            margin-left: 250px;  
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar bg-dark text-white p-3">

        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" width="200" class="mb-2">
            <h5>Maulana Cipta Kreasindo</h5>
        </div>

        <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'bg-primary' : '' }}">🏠 Dashboard</a>
        <a href="/upload" class="menu-item">📥 Import Excel</a>
        <a href="{{ url('/export') }}" class="menu-item">📤 Export Excel</a>
        <a href="{{ url('/export-pdf') }}" class="menu-item">📄 Export PDF</a>

        <hr>

        <form action="/logout" method="POST">
            @csrf
            <button class="btn btn-warning w-100">Logout</button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- NAVBAR -->
        <nav class="navbar navbar-dark bg-dark shadow px-3">
            <span class="navbar-brand">Dashboard Absensi</span>
        </nav>

        <div class="container mt-4">

            <!-- ALERT -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FILTER -->
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

            <!-- BUTTON -->
            <div class="mb-3 d-flex gap-2">
                <a href="/upload" class="btn btn-primary">📥 Import</a>

                <a href="{{ url('/export') }}?nama={{ request('nama') }}&proyek={{ request('proyek') }}&tanggal={{ request('tanggal') }}" 
                   class="btn btn-success">📤 Excel</a>

                <a href="{{ url('/export-pdf') }}?nama={{ request('nama') }}&proyek={{ request('proyek') }}&tanggal={{ request('tanggal') }}" 
                   class="btn btn-danger">📄 PDF</a>
            </div>

            <!-- CARD STATS -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <h6>Total Data</h6>
                            <h3>{{ $totalData }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <h6>Total Upah</h6>
                            <h3>Rp {{ number_format($totalUpah,0,',','.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <h6>Jumlah Karyawan</h6>
                            <h3>{{ $totalTukang }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card shadow mb-4">
                <div class="card-body">

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
                                <td><span class="badge bg-info">{{ $d->proyek }}</span></td>
                                <td>{{ $d->jam_masuk }}</td>
                                <td>{{ $d->jam_pulang }}</td>
                                <td>{{ $d->status }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        Rp {{ number_format($d->upah_harian,0,',','.') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/edit/{{ $d->id }}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="/delete/{{ $d->id }}" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">🗑️</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->links() }}

                </div>
            </div>

            <!-- CHART -->
            <div class="card shadow">
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

    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Upah',
                data: data
            }]
        }
    });
</script>

<!-- Alert Auto Hide -->
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