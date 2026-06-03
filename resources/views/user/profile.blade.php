<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - OnoPay</title>
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

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .profile-header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-blue);
            margin: 0 auto 15px;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .profile-status {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 20px 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #999;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-value {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item:hover {
            background: #f5f7fa;
            padding-left: 10px;
        }

        .menu-item-content {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .menu-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .menu-item-text strong {
            display: block;
            color: var(--primary-dark);
            margin-bottom: 3px;
        }

        .menu-item-text small {
            color: #999;
        }

        .menu-item-arrow {
            color: #ccc;
            font-size: 1.2rem;
        }

        .danger-zone {
            background: #fff5f5;
            border-left: 4px solid #dc3545;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
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

        .icon-edit {
            background: #e3f2fd;
            color: #0066cc;
        }

        .icon-security {
            background: #f3e5f5;
            color: #9c27b0;
        }

        .icon-notification {
            background: #fff3e0;
            color: #ff9800;
        }

        .icon-help {
            background: #e8f5e9;
            color: #4caf50;
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
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-status">
                <i class="bi bi-check-circle-fill" style="color: #28a745;"></i> Akun Aktif
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card" style="padding: 20px;">
            <div class="section-title">Informasi Pribadi</div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-person"></i> Nama Lengkap
                </div>
                <div class="detail-value">{{ $user->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-telephone"></i> Nomor Telepon
                </div>
                <div class="detail-value">{{ $user->phone_number }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-envelope"></i> Email
                </div>
                <div class="detail-value">{{ $user->email ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-calendar-event"></i> Bergabung
                </div>
                <div class="detail-value">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="card" style="padding: 20px;">
            <div class="section-title">Pengaturan Akun</div>

            <a href="#" class="menu-item">
                <div class="menu-item-content">
                    <div class="menu-item-icon icon-edit">
                        <i class="bi bi-pencil"></i>
                    </div>
                    <div class="menu-item-text">
                        <strong>Edit Profil</strong>
                        <small>Ubah informasi pribadi Anda</small>
                    </div>
                </div>
                <div class="menu-item-arrow"><i class="bi bi-chevron-right"></i></div>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-content">
                    <div class="menu-item-icon icon-security">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div class="menu-item-text">
                        <strong>Keamanan</strong>
                        <small>Ubah kata sandi dan pengaturan keamanan</small>
                    </div>
                </div>
                <div class="menu-item-arrow"><i class="bi bi-chevron-right"></i></div>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-content">
                    <div class="menu-item-icon icon-notification">
                        <i class="bi bi-bell"></i>
                    </div>
                    <div class="menu-item-text">
                        <strong>Notifikasi</strong>
                        <small>Kelola pengaturan notifikasi Anda</small>
                    </div>
                </div>
                <div class="menu-item-arrow"><i class="bi bi-chevron-right"></i></div>
            </a>
        </div>

        <!-- Help & Support -->
        <div class="card" style="padding: 20px;">
            <div class="section-title">Bantuan & Dukungan</div>

            <a href="#" class="menu-item">
                <div class="menu-item-content">
                    <div class="menu-item-icon icon-help">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="menu-item-text">
                        <strong>Pusat Bantuan</strong>
                        <small>FAQ dan panduan penggunaan</small>
                    </div>
                </div>
                <div class="menu-item-arrow"><i class="bi bi-chevron-right"></i></div>
            </a>

            <a href="#" class="menu-item">
                <div class="menu-item-content">
                    <div class="menu-item-icon icon-help" style="background: #e0e7ff; color: #4f46e5;">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                    <div class="menu-item-text">
                        <strong>Hubungi Kami</strong>
                        <small>Kontak layanan pelanggan OnoPay</small>
                    </div>
                </div>
                <div class="menu-item-arrow"><i class="bi bi-chevron-right"></i></div>
            </a>
        </div>

        <!-- Danger Zone -->
        <div class="danger-zone">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <i class="bi bi-exclamation-triangle" style="color: #dc3545;"></i>
                <strong style="color: #dc3545;">Zona Berbahaya</strong>
            </div>
            <small style="color: #666;">Aksi di bagian ini tidak dapat dibatalkan.</small>

            <form action="{{ route('user.logout') }}" method="POST" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-item-btn">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('user.wallet') }}" class="nav-item-btn">
            <i class="bi bi-wallet2"></i>
            <span>Wallet</span>
        </a>
        <a href="{{ route('user.transactions') }}" class="nav-item-btn">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="#" class="nav-item-btn active">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
