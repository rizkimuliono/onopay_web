<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnoPay - Digital Wallet & Payment Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
            --accent: #ff6b35;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            margin-left: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .btn-login {
            background: white;
            color: var(--primary-blue);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            margin-left: 10px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 100px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(20px); }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .btn-cta {
            display: inline-block;
            background: white;
            color: var(--primary-blue);
            padding: 14px 35px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .btn-cta:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-cta.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-cta.secondary:hover {
            background: white;
            color: var(--primary-blue);
        }

        /* Features Section */
        .features {
            padding: 80px 30px;
            background: #f5f7fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #666;
        }

        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            margin-bottom: 30px;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 102, 204, 0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 30px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .step {
            position: relative;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: -15px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .step h4 {
            margin-top: 20px;
            margin-bottom: 10px;
            color: var(--primary-dark);
            font-weight: 600;
        }

        .step p {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 60px 30px;
            text-align: center;
        }

        .stat-box {
            margin: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: white;
            padding: 50px 30px 20px;
            text-align: center;
        }

        footer p {
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .footer-links {
            margin-bottom: 30px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            transition: opacity 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .btn-cta {
                display: block;
                margin: 10px 0;
                width: 100%;
            }
        }

        /* Login Modal Styles */
        .login-section {
            padding: 40px 0;
            background: white;
        }

        .login-card {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .login-card h3 {
            color: var(--primary-dark);
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }

        .login-card p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .login-btn-group {
            display: grid;
            gap: 12px;
        }

        .login-option {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .login-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }

        .login-option.admin {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        }

        .login-option.admin:hover {
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="bi bi-wallet2"></i> OnoPay
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="#features">Fitur</a>
                <a class="nav-link" href="#how">Cara Kerja</a>
                <a class="nav-link" href="#docs" target="_blank">API Docs</a>
                <a href="{{ route('user.login') }}" class="btn btn-login">
                    <i class="bi bi-person"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Pembayaran Digital Yang Mudah & Aman</h1>
            <p>Kirim uang, terima pembayaran, dan kelola keuangan Anda dengan OnoPay</p>
            <div>
                <a href="{{ route('user.login') }}" class="btn-cta">
                    <i class="bi bi-person-fill"></i> Login Pengguna
                </a>
                <a href="{{ route('login') }}" class="btn-cta secondary">
                    <i class="bi bi-key"></i> Admin Panel
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih OnoPay?</h2>
                <p>Solusi pembayaran terpadu untuk semua kebutuhan finansial Anda</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-qr-code"></i>
                        </div>
                        <h3>Pembayaran QR Code</h3>
                        <p>Kirim uang dengan mudah menggunakan QR Code. Penerima hanya perlu scan untuk menerima pembayaran.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3>Keamanan Tingkat Bank</h3>
                        <p>Enkripsi end-to-end dan standar keamanan internasional untuk melindungi data Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning"></i>
                        </div>
                        <h3>Transfer Instan</h3>
                        <p>Pembayaran diproses secara real-time. Penerima langsung menerima dana tanpa penundaan.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h3>E-Wallet Terpadu</h3>
                        <p>Satu akun untuk semua kebutuhan pembayaran, transfer, dan pengelolaan saldo digital Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3>Dashboard Lengkap</h3>
                        <p>Pantau seluruh transaksi, saldo, dan riwayat pembayaran dalam satu dashboard yang intuitif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-api"></i>
                        </div>
                        <h3>API Terbuka</h3>
                        <p>Integrasi mudah ke aplikasi pihak ketiga dengan API REST yang lengkap dan dokumentasi yang jelas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how">
        <div class="container">
            <div class="section-title">
                <h2>Bagaimana Cara Kerjanya?</h2>
                <p>Proses pembayaran OnoPay sangat mudah dan cepat</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Registrasi Akun</h4>
                    <p>Buat akun gratis dengan nomor telepon yang valid. Proses hanya membutuhkan waktu 2 menit.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Buat Permintaan Bayar</h4>
                    <p>Input nominal pembayaran dan deskripsi, sistem akan generate QR Code unik untuk Anda.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Bagikan QR Code</h4>
                    <p>Bagikan QR Code ke pembayar melalui WhatsApp, Email, atau metode lain yang Anda inginkan.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Pembeli Membayar</h4>
                    <p>Pembeli scan QR Code dan melakukan pembayaran dengan mengkonfirmasi nominal dan penerima.</p>
                </div>
                <div class="step">
                    <div class="step-number">5</div>
                    <h4>Dana Masuk Instan</h4>
                    <p>Uang langsung masuk ke akun Anda. Lihat notifikasi dan detail transaksi di dashboard.</p>
                </div>
                <div class="step">
                    <div class="step-number">6</div>
                    <h4>Kelola Saldo</h4>
                    <p>Gunakan saldo Anda untuk membayar atau tarik ke rekening bank Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">Rp 2.5B</div>
                        <div class="stat-label">Volume Transaksi</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Customer Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="login-section">
        <div class="container">
            <div class="login-card">
                <h3><i class="bi bi-person-check"></i> Mulai Sekarang</h3>
                <p>Pilih role Anda untuk login atau register</p>
                <div class="login-btn-group">
                    <a href="{{ route('user.login') }}" class="login-option">
                        <i class="bi bi-person"></i> Login Pengguna
                    </a>
                    <a href="{{ route('user.register') }}" class="login-option" style="background: linear-gradient(135deg, #0066cc80 0%, #003d7a80 100%); border: 2px solid var(--primary-blue);">
                        <i class="bi bi-person-plus"></i> Daftar Pengguna Baru
                    </a>
                    <a href="{{ route('login') }}" class="login-option admin">
                        <i class="bi bi-key"></i> Login Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-links">
                <a href="{{ route('api-docs') }}" target="_blank"><i class="bi bi-code-square"></i> API Documentation</a>
                <a href="#"><i class="bi bi-file-text"></i> Terms & Conditions</a>
                <a href="#"><i class="bi bi-shield"></i> Privacy Policy</a>
            </div>
            <p>&copy; 2026 OnoPay. All rights reserved. | Solusi Pembayaran Digital Terpercaya Indonesia</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
