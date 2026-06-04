<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Saya - OnoPay</title>
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

        .qr-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 16px;
            margin-bottom: 14px;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 14px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-active { background: #d1e7dd; color: #0a3622; }
        .status-used { background: #d1ecf1; color: #0c5460; }
        .status-expired { background: #fff3cd; color: #664d03; }
        .status-cancelled { background: #f8d7da; color: #842029; }

        .mode-badge {
            background: var(--light-blue);
            color: var(--primary-dark);
            border-radius: 14px;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .meta-row {
            font-size: 0.85rem;
            color: #666;
            margin-top: 8px;
        }

        .qr-code-text {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: var(--primary-dark);
            word-break: break-all;
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            color: #999;
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

        .nav-item-btn i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="top-navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('user.dashboard') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-chevron-left"></i> Kembali
            </a>
            <div style="font-weight: 700;"><i class="bi bi-wallet2"></i> OnoPay</div>
            <a href="{{ route('user.payment-create') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-plus-circle"></i>
            </a>
        </div>
    </div>

    <div class="container-main">
        <div style="margin-bottom: 16px;">
            <h4 style="color: var(--primary-dark); font-weight: 700; margin: 0;">Status QR Saya</h4>
            <small style="color: #888;">Lihat QR yang sudah digunakan, expired, atau masih aktif</small>
        </div>

        @if($qrcodes->count() === 0)
            <div class="empty-state">
                <i class="bi bi-qr-code" style="font-size: 2.2rem;"></i>
                <p style="margin-top: 10px;">Belum ada QR yang dibuat.</p>
                <a href="{{ route('user.payment-create') }}" class="btn btn-primary btn-sm">Buat QR Pertama</a>
            </div>
        @else
            @foreach($qrcodes as $qr)
                <div class="qr-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                        <div class="qr-code-text">{{ $qr->code }}</div>
                        <span class="status-badge status-{{ $qr->status }}">{{ $qr->status }}</span>
                    </div>

                    <div style="margin-top: 8px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <span class="mode-badge">{{ $qr->qr_mode === 'reusable' ? 'Berulang' : 'Sekali Pakai' }}</span>
                        <strong style="color: var(--primary-blue);">Rp {{ number_format($qr->amount, 0) }}</strong>
                    </div>

                    <div class="meta-row">
                        <i class="bi bi-calendar3"></i> Dibuat: {{ $qr->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="meta-row">
                        <i class="bi bi-clock"></i>
                        @if($qr->expires_at)
                            Expired: {{ $qr->expires_at->format('d/m/Y H:i') }}
                        @else
                            Tanpa batas waktu
                        @endif
                    </div>

                    @if($qr->description)
                        <div class="meta-row"><i class="bi bi-file-text"></i> {{ $qr->description }}</div>
                    @endif

                    <div style="margin-top: 10px; display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ route('user.payment-show', $qr->code) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        @if($qr->qr_image)
                            <a href="{{ $qr->qr_image }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-image"></i> URL Gambar QR
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mt-3">
                {{ $qrcodes->links() }}
            </div>
        @endif
    </div>

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
        <a href="{{ route('user.profile') }}" class="nav-item-btn">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
