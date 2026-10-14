<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM Bengkel & POS</title>
    <!-- Memuat Bootstrap 5 CSS (Sesuai spesifikasi desain SRS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0d1117; /* Tema gelap mockup Figma */
            color: #c9d1d9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            background-color: #161b22;
            border: 1px solid #30363d;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            background-color: #0d1117;
            border: 1px solid #30363d;
            color: #c9d1d9;
        }
        .form-control:focus {
            background-color: #0d1117;
            border-color: #58a6ff;
            color: #c9d1d9;
            box-shadow: 0 0 0 0.2rem rgba(88, 166, 255, 0.25);
        }
        .btn-primary {
            background-color: #238636;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2ea043;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Logo / Judul Sistem -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-white">SIM - Bengkel</h3>
                    <p class="text-muted small">Sistem Manajemen Bengkel & POS Multi-Tenant</p>
                </div>

                <!-- Card Form Login -->
                <div class="card card-login p-4">
                    <h5 class="fw-semibold mb-3 text-white text-center">Silakan Masuk</h5>

                    <!-- Menampilkan Error jika Gagal Login -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Login -->
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label small text-muted">Email Pengguna</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@bengkel.com">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small text-muted">Kata Sandi (Password)</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-semibold">Masuk ke Sistem</button>
                        </div>
                    </form>
                </div>

                <!-- Footer Kecil -->
                <div class="text-center mt-4 text-muted small">
                    &copy; 2026 SIM-Bengkel SaaS Platform
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>