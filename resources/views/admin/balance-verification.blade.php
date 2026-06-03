<!-- Admin Balance Verification Page -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Saldo - OnoPay Admin</title>
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

        .sidebar {
            background: var(--primary-dark);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            overflow-y: auto;
        }

        .sidebar-title {
            padding: 0 20px 20px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .sidebar-menu-item {
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .sidebar-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 25px;
        }

        .sidebar-menu-item.active {
            background: var(--primary-blue);
            color: white;
            border-left: 4px solid white;
            padding-left: 16px;
        }

        .main-container {
            margin-left: 250px;
            padding: 30px;
        }

        .page-title {
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background: var(--light-blue);
            color: var(--primary-dark);
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 10px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.15);
        }

        .btn-primary {
            background: var(--primary-blue);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .balance-display {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .balance-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .balance-amount {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 5px;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: var(--light-blue);
            color: var(--primary-dark);
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            border-color: #e0e0e0;
        }

        .badge-add {
            background: #28a745;
            color: white;
        }

        .badge-subtract {
            background: #dc3545;
            color: white;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .adjustment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-container {
                margin-left: 200px;
                padding: 20px;
            }

            .adjustment-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-title">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </div>
        <a href="{{ route('dashboard') }}" class="sidebar-menu-item">
            <i class="bi bi-house"></i> Dashboard
        </a>
        <a href="{{ route('user.index') }}" class="sidebar-menu-item">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('transaction.index') }}" class="sidebar-menu-item">
            <i class="bi bi-receipt"></i> Transactions
        </a>
        <a href="{{ route('admin.topup-pending') }}" class="sidebar-menu-item">
            <i class="bi bi-clock-history"></i> Pending Topups
        </a>
        <a href="{{ route('admin.balance-verification') }}" class="sidebar-menu-item active">
            <i class="bi bi-wallet2"></i> Verifikasi Saldo
        </a>
        <a href="{{ route('admin.topup-settings') }}" class="sidebar-menu-item">
            <i class="bi bi-gear"></i> Topup Settings
        </a>
        <hr style="margin: 15px 0; border-color: rgba(255, 255, 255, 0.1);">
        <a href="{{ route('logout') }}" class="sidebar-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="page-title">
            <i class="bi bi-wallet2"></i> Verifikasi & Adjustment Saldo User
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                <strong>{{ $errors->first() }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="adjustment-grid">
            <!-- Form Card -->
            <div class="card" style="height: fit-content;">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> Adjustment Saldo
                </div>
                <div style="padding: 20px;">
                    <form method="POST" action="{{ route('admin.balance-adjust') }}" id="adjustForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Pilih User</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="userSelect" required onchange="loadUserBalance()">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone_number }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="balanceDisplay" style="display: none;">
                            <div class="balance-display">
                                <div class="balance-label">Saldo Saat Ini</div>
                                <div class="balance-amount" id="currentBalance">Rp 0</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipe Adjustment</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeAdd" value="add" checked required>
                                    <label class="form-check-label" for="typeAdd">
                                        <i class="bi bi-plus-circle"></i> Tambah Saldo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeSubtract" value="subtract" required>
                                    <label class="form-check-label" for="typeSubtract">
                                        <i class="bi bi-dash-circle"></i> Kurangi Saldo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah (Rp)</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                   name="amount" placeholder="0" min="0.01" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alasan Adjustment</label>
                            <select class="form-select @error('reason') is-invalid @enderror" name="reason" required>
                                <option value="">-- Pilih Alasan --</option>
                                <option value="Koreksi transaksi">Koreksi transaksi</option>
                                <option value="Refund pembayaran">Refund pembayaran</option>
                                <option value="Kompensasi masalah teknis">Kompensasi masalah teknis</option>
                                <option value="Verifikasi manual topup">Verifikasi manual topup</option>
                                <option value="Penyesuaian duplikasi">Penyesuaian duplikasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Proses Adjustment
                        </button>
                    </form>
                </div>
            </div>

            <!-- History Card -->
            <div class="card" style="height: fit-content;">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> History Adjustment Terakhir
                </div>
                <div style="padding: 20px;">
                    <div id="adjustmentHistory" style="max-height: 400px; overflow-y: auto;">
                        @if ($adjustments->isEmpty())
                            <div style="text-align: center; color: #999; padding: 20px;">
                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                Belum ada adjustment
                            </div>
                        @else
                            @foreach ($adjustments as $adj)
                                <div style="border-bottom: 1px solid #e0e0e0; padding: 12px 0;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <strong>{{ $adj->user->name }}</strong>
                                        <span class="badge {{ $adj->type === 'add' ? 'badge-add' : 'badge-subtract' }}">
                                            {{ $adj->type === 'add' ? '+' : '-' }} Rp {{ number_format($adj->amount, 0) }}
                                        </span>
                                    </div>
                                    <small style="color: #666;">
                                        {{ $adj->reason }} | {{ $adj->admin->name ?? 'System' }}
                                    </small>
                                    <div style="font-size: 0.75rem; color: #999; margin-top: 3px;">
                                        {{ $adj->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadUserBalance() {
            const userId = document.getElementById('userSelect').value;
            if (!userId) {
                document.getElementById('balanceDisplay').style.display = 'none';
                return;
            }

            fetch(`/admin/balance-verification/user/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('currentBalance').textContent =
                            'Rp ' + new Intl.NumberFormat('id-ID').format(data.user.balance);
                        document.getElementById('balanceDisplay').style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
