<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
    <div class="card shadow rounded-4">
        
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">✏️ Edit Data Tukang</h4>
        </div>

        <div class="card-body">

            <form action="/update/{{ $data->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Tukang</label>
                    <input type="text" name="nama_tukang" 
                           value="{{ $data->nama_tukang }}" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" 
                           value="{{ $data->jabatan }}" 
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Proyek</label>
                    <input type="text" name="proyek" 
                           value="{{ $data->proyek }}" 
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upah Harian</label>
                    <input type="number" name="upah_harian" 
                           value="{{ $data->upah_harian }}" 
                           class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    
                    <!-- Tombol Kembali -->
                    <a href="/dashboard" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <!-- Tombol Update -->
                    <button class="btn btn-success">
                        💾 Update Data
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
</body>
</html>