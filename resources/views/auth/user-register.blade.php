<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - OnoPay User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .register-header .subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .register-body {
            padding: 30px;
        }

        .form-control, .form-control:focus {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.15);
        }

        .btn-register {
            background: var(--primary-blue);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: var(--primary-dark);
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .register-footer {
            text-align: center;
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            background: #f8f9fa;
        }

        .register-footer p {
            margin: 0;
            color: #666;
        }

        .register-footer a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .features {
            background: var(--light-blue);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .features h6 {
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .features ul {
            margin: 0;
            padding-left: 20px;
            color: #555;
        }

        .features li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <h1><i class="bi bi-wallet2"></i></h1>
                <h1>OnoPay</h1>
                <div class="subtitle">Daftar & Mulai Transaksi</div>
            </div>

            <!-- Body -->
            <div class="register-body">
                <div class="features">
                    <h6><i class="bi bi-check-circle"></i> Keuntungan OnoPay:</h6>
                    <ul>
                        <li>Transaksi peer-to-peer gratis</li>
                        <li>Keamanan tingkat bank</li>
                        <li>Integrasi dengan merchant pihak ketiga</li>
                    </ul>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>{{ $errors->first() }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('user.register.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i> Nama Lengkap
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" placeholder="Masukkan nama lengkap"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" placeholder="Masukkan email"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            <i class="bi bi-telephone"></i> Nomor Telepon
                        </label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                               id="phone" name="phone_number" placeholder="Contoh: 08123456789"
                               value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Minimal 6 karakter"
                               required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock"></i> Konfirmasi Password
                        </label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi password"
                               required>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="#" style="color: var(--primary-blue);">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register mb-3">
                        <i class="bi bi-check-circle"></i> Daftar Sekarang
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="register-footer">
                <p>Sudah punya akun? <a href="{{ route('user.login') }}">Masuk di sini</a></p>
            </div>
        </div>

        <!-- Info Text -->
        <div style="text-align: center; margin-top: 30px; color: white;">
            <small style="opacity: 0.8;">
                Proses registrasi cepat dan mudah. Gratis untuk semua pengguna.
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
