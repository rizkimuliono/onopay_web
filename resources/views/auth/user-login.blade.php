<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OnoPay User</title>
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
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .login-header .subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .login-body {
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

        .btn-login {
            background: var(--primary-blue);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        .login-footer {
            text-align: center;
            padding: 20px 30px;
            border-top: 1px solid #e0e0e0;
            background: #f8f9fa;
        }

        .login-footer p {
            margin: 0;
            color: #666;
        }

        .login-footer a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .input-group-icon {
            position: relative;
        }

        .input-group-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .input-group-icon input {
            padding-left: 45px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <h1><i class="bi bi-wallet2"></i></h1>
                <h1>OnoPay</h1>
                <div class="subtitle">E-Wallet Digital Anda</div>
            </div>

            <!-- Body -->
            <div class="login-body">
                <h4 class="mb-4" style="text-align: center; color: var(--primary-dark); font-weight: 600;">Masuk ke Akun Anda</h4>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>{{ $errors->first() }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('user.login.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="phone" class="form-label">
                            <i class="bi bi-telephone"></i> Nomor Telepon
                        </label>
                        <div class="input-group-icon">
                            <i class="bi bi-telephone"></i>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                   id="phone" name="phone_number" placeholder="Contoh: 08123456789"
                                   value="{{ old('phone_number') }}" required>
                        </div>
                        @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <div class="input-group-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Masukkan password"
                                   required>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login mb-3">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </button>
                </form>

                <div style="text-align: center; color: #999; font-size: 0.9rem;">
                    atau
                </div>

                <button class="btn btn-outline-secondary w-100 mt-3" onclick="alert('Demo QR scan - Akan dimulai segera')">
                    <i class="bi bi-qr-code"></i> Scan QR Code
                </button>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>Belum punya akun? <a href="{{ route('user.register') }}">Daftar di sini</a></p>
            </div>
        </div>

        <!-- Info Text -->
        <div style="text-align: center; margin-top: 30px; color: white;">
            <small style="opacity: 0.8;">
                OnoPay adalah platform e-wallet digital untuk kemudahan transaksi Anda.<br>
                Aman, cepat, dan terpercaya.
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
