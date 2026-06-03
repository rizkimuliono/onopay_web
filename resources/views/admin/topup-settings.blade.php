<!-- Admin Topup Settings Management Page -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topup Settings - OnoPay Admin</title>
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

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-blue);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .setting-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .setting-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .setting-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }

        .setting-control {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert {
            border-radius: 8px;
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
        <a href="{{ route('admin.balance-verification') }}" class="sidebar-menu-item">
            <i class="bi bi-wallet2"></i> Verifikasi Saldo
        </a>
        <a href="{{ route('admin.topup-settings') }}" class="sidebar-menu-item active">
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
            <i class="bi bi-gear"></i> Pengaturan Topup
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Topup Verification Setting -->
        <div class="setting-item">
            <div class="setting-title">
                <i class="bi bi-shield-check"></i> Verifikasi Topup Auto-Approve
            </div>
            <div class="setting-description">
                Aktifkan sistem untuk memerlukan verifikasi admin sebelum topup user diproses
            </div>

            <form method="POST" action="{{ route('admin.topup-settings-update') }}">
                @csrf
                <div class="setting-control">
                    <div>
                        <div style="font-weight: 600; margin-bottom: 5px;">
                            {{ $verificationEnabled ? '🟢 Verifikasi AKTIF' : '🔴 Verifikasi NONAKTIF' }}
                        </div>
                        <div style="font-size: 0.85rem; color: #666;">
                            @if ($verificationEnabled)
                                Topup user harus diverifikasi admin terlebih dahulu
                            @else
                                Topup user langsung berhasil tanpa verifikasi
                            @endif
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="topup_verification_enabled" value="1"
                               {{ $verificationEnabled ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="slider"></span>
                    </label>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Penjelasan Modus
            </div>
            <div style="padding: 20px;">
                <div style="margin-bottom: 20px;">
                    <h6 style="color: var(--primary-blue); font-weight: 600;">🔴 Verifikasi NONAKTIF (Default)</h6>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        <li>User melakukan topup</li>
                        <li>Saldo user langsung bertambah</li>
                        <li>Transaksi langsung berhasil</li>
                        <li>Admin tidak perlu melakukan approval</li>
                        <li>Cocok untuk sistem topup otomatis (payment gateway)</li>
                    </ul>
                </div>

                <div>
                    <h6 style="color: var(--primary-blue); font-weight: 600;">🟢 Verifikasi AKTIF</h6>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        <li>User melakukan topup</li>
                        <li>Transaksi masuk status PENDING</li>
                        <li>Saldo user belum bertambah</li>
                        <li>Admin harus approve/reject di menu "Pending Topups"</li>
                        <li>Setelah diapprove, baru saldo bertambah dan transaksi berhasil</li>
                        <li>Cocok untuk verifikasi manual atau fraud prevention</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Affected Areas -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-arrow-repeat"></i> Area Yang Terpengaruh
            </div>
            <div style="padding: 20px;">
                <div style="margin-bottom: 15px;">
                    <strong>Web Interface:</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                        <li>/app/topup - Form topup</li>
                        <li>Proses POST /app/topup</li>
                    </ul>
                </div>
                <div>
                    <strong>API Endpoint:</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                        <li>POST /api/v1/payment/topup</li>
                        <li>Respons HTTP 202 saat verification enabled (pending)</li>
                        <li>Respons HTTP 200 saat verification disabled (success)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
