<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — Web Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2035 0%, #1c3461 60%, #1976d2 100%);
            display: flex;
            align-items: center;
        }
        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,.25);
        }
        .auth-card .card-header {
            background: linear-gradient(135deg, #1976d2, #1565c0);
            border-radius: 1rem 1rem 0 0;
            padding: 2rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card auth-card">
                <div class="card-header text-center text-white">
                    <i class="bi bi-mortarboard-fill fs-1 text-warning d-block mb-2"></i>
                    <h4 class="mb-0 fw-bold">Web Sekolah</h4>
                    <p class="mb-0 opacity-75 small">Sistem Informasi Terintegrasi</p>
                </div>
                <div class="card-body p-4">
                    @yield('content')
                </div>
            </div>

            <p class="text-center text-white-50 small mt-3">
                &copy; {{ date('Y') }} Modul Manajemen Pengguna
            </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
