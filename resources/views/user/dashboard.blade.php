<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OnoPay</title>
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

        .top-navbar .brand {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .main-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .welcome-card h2 {
            margin: 0 0 10px 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .welcome-card .balance-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .welcome-card .balance-amount {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .action-btn i {
            font-size: 1.5rem;
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

        .transaction-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .transaction-info {
            flex: 1;
        }

        .transaction-type {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .transaction-time {
            font-size: 0.85rem;
            color: #999;
        }

        .transaction-amount {
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 1rem;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
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
            transition: all 0.3s ease;
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

        .pb-80 {
            padding-bottom: 80px;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="brand"><i class="bi bi-wallet2"></i> OnoPay</div>
            <form action="{{ route('user.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container pb-80">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>Halo, {{ $user->name }}!</h2>
            <div class="balance-label"><i class="bi bi-wallet"></i> Saldo Anda</div>
            <div class="balance-amount">Rp {{ number_format($user->balance, 0) }}</div>

            <div class="quick-actions">
                <a href="{{ route('user.payment-create') }}" class="action-btn">
                    <i class="bi bi-qr-code"></i>
                    <span>Minta Bayar</span>
                </a>
                <a href="{{ route('user.payment-input') }}" class="action-btn">
                    <i class="bi bi-download"></i>
                    <span>Bayar QR</span>
                </a>
                <a href="{{ route('user.wallet') }}" class="action-btn">
                    <i class="bi bi-piggy-bank"></i>
                    <span>Wallet</span>
                </a>
                <a href="{{ route('user.transactions') }}" class="action-btn">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat</span>
                </a>
            </div>
        </div>

        <!-- Statistik -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px;">
            <div class="card">
                <div style="padding: 15px; text-align: center;">
                    <div style="font-size: 0.85rem; color: #999; margin-bottom: 5px;">Total Transaksi</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue);">
                        {{ $recentTransactions->count() ?? 0 }}
                    </div>
                </div>
            </div>
            <div class="card">
                <div style="padding: 15px; text-align: center;">
                    <div style="font-size: 0.85rem; color: #999; margin-bottom: 5px;">Status Akun</div>
                    <div style="font-size: 1.2rem;">
                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div>
            <div class="section-title">📊 Transaksi Terbaru</div>

            @if ($recentTransactions->count() > 0)
                <div class="card">
                    @foreach ($recentTransactions as $tx)
                        <div class="transaction-item">
                            <div style="display: flex; align-items: center; flex: 1;">
                                <div class="transaction-icon" style="background: @if($tx->type === 'payment') #0066cc @else #28a745 @endif;">
                                    <i class="bi @if($tx->type === 'payment') bi-arrow-up-right @else bi-arrow-down-left @endif"></i>
                                </div>
                                <div class="transaction-info">
                                    <div class="transaction-type">
                                        @if ($tx->type === 'payment')
                                            Pembayaran
                                        @elseif ($tx->type === 'topup')
                                            Top-up
                                        @else
                                            {{ ucfirst($tx->type) }}
                                        @endif
                                    </div>
                                    <div class="transaction-time">{{ $tx->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div>
                                <div class="transaction-amount">Rp {{ number_format($tx->amount, 0) }}</div>
                                <small class="badge
                                    @if($tx->status === 'success') badge-success
                                    @elseif($tx->status === 'pending') badge-pending
                                    @else bg-danger
                                    @endif">
                                    @if($tx->status === 'success') ✓ Berhasil
                                    @elseif($tx->status === 'pending') ⏱ Pending
                                    @else ✗ Gagal @endif
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Belum ada transaksi
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <button class="nav-item-btn active" onclick="navigate('{{ route('user.dashboard') }}')">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </button>
        <button class="nav-item-btn" onclick="navigate('{{ route('user.wallet') }}')">
            <i class="bi bi-wallet2"></i>
            <span>Wallet</span>
        </button>
        <button class="nav-item-btn" onclick="navigate('{{ route('user.transactions') }}')">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </button>
        <button class="nav-item-btn" onclick="navigate('{{ route('user.profile') }}')">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function navigate(url) {
            window.location.href = url;
        }

        function promptQRCode(e) {
            e.preventDefault();
            const qrCode = prompt('Masukkan QR Code atau nomor referensi:');
            if (qrCode) {
                window.location.href = '{{ route("user.payment-confirm", "") }}' + qrCode;
            }
        }
    </script>
</body>
</html>
