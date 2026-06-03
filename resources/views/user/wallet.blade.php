<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet - OnoPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container-main {
            max-width: 100%;
            padding: 20px;
            padding-bottom: 100px;
        }

        .wallet-card {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .wallet-card .label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .wallet-card .balance {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .wallet-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .info-item-label {
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .info-item-value {
            font-weight: 700;
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 15px;
            margin-top: 25px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .card-header {
            background: var(--light-blue);
            color: var(--primary-dark);
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .activity-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-info {
            flex: 1;
        }

        .activity-type {
            font-weight: 600;
            color: #333;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #999;
            margin-top: 3px;
        }

        .activity-amount {
            font-weight: 700;
            color: var(--primary-dark);
        }

        .bottom-nav {
            background: white;
            border-top: 1px solid #e0e0e0;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-item-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px;
            text-align: center;
            color: #999;
            font-size: 0.75rem;
            cursor: pointer;
            text-decoration: none;
        }

        .nav-item-btn.active {
            color: var(--primary-blue);
        }

        .nav-item-btn:hover {
            color: var(--primary-blue);
        }

        .nav-item-btn i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('user.dashboard') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-chevron-left"></i> Kembali
            </a>
            <div style="font-weight: 700;"><i class="bi bi-wallet2"></i> OnoPay</div>
            <div style="width: 40px;"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container-main">
        <!-- Wallet Card -->
        <div class="wallet-card">
            <div class="label"><i class="bi bi-wallet"></i> Saldo Dompet Anda</div>
            <div class="balance">Rp {{ number_format($user->balance, 0) }}</div>

            <div class="wallet-info">
                <div class="info-item">
                    <div class="info-item-label">Status Akun</div>
                    <div class="info-item-value" style="color: #4ade80;">Aktif</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">Member Sejak</div>
                    <div class="info-item-value">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px;">
            <a href="{{ route('user.payment-create') }}" class="btn btn-primary" style="padding: 15px; border-radius: 10px;">
                <i class="bi bi-qr-code"></i><br>
                <small>Minta Bayar</small>
            </a>
            <a href="{{ route('user.payment-input') }}" class="btn btn-outline-primary" style="padding: 15px; border-radius: 10px;">
                <i class="bi bi-download"></i><br>
                <small>Bayar QR</small>
            </a>
        </div>

        <!-- Wallet Details -->
        <div class="section-title">📋 Detail Dompet</div>
        <div class="card">
            <div style="padding: 15px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                <span style="color: #999;">Nama Pemilik</span>
                <strong>{{ $user->name }}</strong>
            </div>
            <div style="padding: 15px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                <span style="color: #999;">Nomor Telepon</span>
                <strong>{{ $user->phone_number }}</strong>
            </div>
            <div style="padding: 15px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between;">
                <span style="color: #999;">Email</span>
                <strong style="font-size: 0.9rem;">{{ $user->email }}</strong>
            </div>
            <div style="padding: 15px; display: flex; justify-content: space-between;">
                <span style="color: #999;">Tanggal Bergabung</span>
                <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
            </div>
        </div>

        <!-- Security Info -->
        <div class="section-title">🔒 Keamanan</div>
        <div class="card">
            <div style="padding: 20px; text-align: center;">
                <i class="bi bi-shield-check" style="font-size: 2rem; color: #28a745;"></i>
                <p style="margin-top: 10px; color: #666;">
                    <strong>Akun Anda Aman</strong><br>
                    <small>Gunakan password yang kuat dan jangan bagikan pin Anda dengan siapa pun</small>
                </p>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-item-btn">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('user.wallet') }}" class="nav-item-btn active">
            <i class="bi bi-wallet2"></i>
            <span>Wallet</span>
        </a>
        <a href="{{ route('user.transactions') }}" class="nav-item-btn">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('user.profile') }}" class="nav-item-btn">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
