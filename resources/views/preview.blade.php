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
            <div class="mb-3">
                <strong>Total Data:</strong> {{ count($data) - 1 }} <br>
                <strong>Error:</strong> {{ count($errors) }}
            </div>

            <!-- Error List -->
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    @foreach($data as $i => $row)
                        <tr class="{{ $i == 0 ? 'table-dark' : '' }}">
                            @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>

            <form action="/import" method="POST">
                @csrf
                <button class="btn btn-success" {{ count($errors) > 0 ? 'disabled' : '' }}>
                Import ke Database
                </button>
                <a href="/" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>

</body>
</html>