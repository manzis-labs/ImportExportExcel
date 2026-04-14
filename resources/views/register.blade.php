<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 text-center bg-black" style="width: 400px;">
        
        <h4 class="text-center mb-3 text-light">Register</h4>
            <!-- LOGO -->
        <div class="mb-3">
            <img src="{{ asset('images/login.png') }}" alt="Logo" width="250">
        </div>

        <p class="text-center text-light">Maulana Cipta Kreasindo</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3 text-start text-light">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3 text-start text-light">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3 text-start text-light">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 text-start text-light">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Daftar
            </button>

            <div class="text-center mt-3">
                <a href="/login">Sudah punya akun? Login</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>