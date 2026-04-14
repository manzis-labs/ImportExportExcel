<!DOCTYPE html>
<html>
<head>
    <title>Preview Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Preview Data Excel</h4>
        </div>

        <div class="card-body">

            <!-- Statistik -->
                @if(count($errors))
                <div class="alert alert-danger">
                    <b>Error:</b>
                    <ul>
                        @foreach($errors as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- @if(count($warnings))
                <div class="alert alert-warning">
                    <b>Warning (Duplikat):</b>
                    <ul>
                        @foreach($warnings as $w)
                        <li>{{ $w }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif -->

            <!-- Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Proyek</th>
                            <th>Upah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preview as $row)
                        <tr class="
                                @if($row['is_error']) table-danger
                                @elseif($row['duplicate']) table-warning
                                @endif
                            ">
                            <td>{{ $row['no'] }}</td>
                            <td>{{ $row['tanggal'] }}</td>
                            <td>{{ $row['nama_tukang'] }}</td>
                            <td>{{ $row['proyek'] }}</td>
                            <td>{{ $row['upah_harian'] }}</td>
                            <td>
                                @if($row['duplicate'])
                                    <span class="badge bg-danger">Duplicate</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form action="/import" method="POST">
                @csrf
                @if(count($errors) == 0)
                <button class="btn btn-success">Import ke Database</button>
                @else
                    <button class="btn btn-secondary" disabled>
                    Tidak bisa import (masih ada error)
                    </button>
                @endif
                <a href="/upload" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>

</body>
</html>