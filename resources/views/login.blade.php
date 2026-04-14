<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Maulana Cipta Kreasindo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4 text-center bg-black" style="width: 350px;">

        <!-- LOGO -->
        <div class="mb-3">
            <img src="{{ asset('images/login.png') }}" alt="Logo" width="200">
        </div>

        <!-- NAMA PERUSAHAAN -->
        <h6 class="text-light mb-2">Maulana Cipta Kreasindo</h6>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-3 text-start text-light">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3 text-start text-light">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-warning w-100 text-light">
                Login
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="/register">Belum punya akun? Daftar</a>
        </div>

    </div>

</div>

</body>
</html>