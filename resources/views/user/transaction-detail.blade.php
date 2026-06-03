<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - OnoPay</title>
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

        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 20px auto;
        }

        .status-icon.success {
            background: #28a745;
        }

        .status-icon.pending {
            background: #ffc107;
        }

        .status-icon.failed {
            background: #dc3545;
        }

        .transaction-header {
            text-align: center;
            padding: 20px;
        }

        .transaction-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 15px 0;
        }

        .transaction-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .transaction-status.success {
            background: #d1e7dd;
            color: #0a3622;
        }

        .transaction-status.pending {
            background: #fff3cd;
            color: #664d03;
        }

        .transaction-status.failed {
            background: #f8d7da;
            color: #842029;
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
            color: #666;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-weight: 600;
            color: var(--primary-dark);
            text-align: right;
            word-break: break-word;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 20px 0 15px 0;
            padding-left: 15px;
        }

        .details-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
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

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-action {
            padding: 12px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn-action.primary {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 20px;
        }

        .timeline-marker {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-weight: 600;
            color: white;
        }

        .timeline-marker.active {
            background: var(--primary-blue);
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 3px;
        }

        .timeline-time {
            font-size: 0.85rem;
            color: #999;
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #0066cc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box strong {
            display: block;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .info-box small {
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('user.transactions') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-chevron-left"></i> Kembali
            </a>
            <div style="font-weight: 700;"><i class="bi bi-wallet2"></i> OnoPay</div>
            <div style="width: 40px;"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container-main">
        <!-- Transaction Header -->
        <div class="card">
            <div class="transaction-header">
                <div class="status-icon @if($transaction->status === 'success') success @elseif($transaction->status === 'pending') pending @else failed @endif">
                    @if($transaction->status === 'success')
                        <i class="bi bi-check"></i>
                    @elseif($transaction->status === 'pending')
                        <i class="bi bi-hourglass-split"></i>
                    @else
                        <i class="bi bi-x"></i>
                    @endif
                </div>

                <div class="transaction-amount">
                    @if($transaction->type === 'payment')
                        -Rp{{ number_format($transaction->amount, 0) }}
                    @else
                        +Rp{{ number_format($transaction->amount, 0) }}
                    @endif
                </div>

                <div class="transaction-status @if($transaction->status === 'success') success @elseif($transaction->status === 'pending') pending @else failed @endif">
                    @if($transaction->status === 'success')
                        ✓ Berhasil
                    @elseif($transaction->status === 'pending')
                        ⏱ Pending
                    @else
                        ✗ Gagal
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="details-card">
            <div class="section-title">
                <i class="bi bi-info-circle"></i> Detail Transaksi
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-hash"></i> ID Transaksi
                </div>
                <div class="detail-value">
                    {{ $transaction->transaction_id }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-tag"></i> Jenis Transaksi
                </div>
                <div class="detail-value">
                    @if($transaction->type === 'payment')
                        Pembayaran
                    @elseif($transaction->type === 'topup')
                        Top-up Saldo
                    @else
                        {{ ucfirst($transaction->type) }}
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-receipt"></i> Deskripsi
                </div>
                <div class="detail-value">
                    {{ $transaction->description ?? '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-calendar-event"></i> Tanggal
                </div>
                <div class="detail-value">
                    {{ $transaction->created_at->format('d M Y') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">
                    <i class="bi bi-clock"></i> Waktu
                </div>
                <div class="detail-value">
                    {{ $transaction->created_at->format('H:i:s') }}
                </div>
            </div>

            @if($transaction->completed_at)
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-flag-fill"></i> Selesai Pada
                    </div>
                    <div class="detail-value">
                        {{ $transaction->completed_at->format('d M Y H:i:s') }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Status Timeline -->
        <div class="details-card">
            <div class="section-title">
                <i class="bi bi-diagram-2"></i> Timeline Status
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker active">1</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Transaksi Dibuat</div>
                        <div class="timeline-time">{{ $transaction->created_at->format('d M Y H:i:s') }}</div>
                    </div>
                </div>

                @if($transaction->status === 'success')
                    <div class="timeline-item">
                        <div class="timeline-marker active">2</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Transaksi Berhasil</div>
                            <div class="timeline-time">{{ $transaction->completed_at->format('d M Y H:i:s') ?? 'Segera' }}</div>
                        </div>
                    </div>
                @elseif($transaction->status === 'pending')
                    <div class="timeline-item">
                        <div class="timeline-marker">2</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Menunggu Konfirmasi</div>
                            <div class="timeline-time">Sedang Diproses</div>
                        </div>
                    </div>
                @else
                    <div class="timeline-item">
                        <div class="timeline-marker">2</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Transaksi Gagal</div>
                            <div class="timeline-time">Tidak dapat diproses</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <strong><i class="bi bi-shield-check"></i> Keamanan Transaksi</strong>
            <small>
                Transaksi Anda dilindungi dengan enkripsi tingkat bank.
                Jika ada pertanyaan, hubungi layanan pelanggan kami.
            </small>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-action" onclick="shareTransaction()">
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn-action primary" onclick="downloadReceipt()">
                <i class="bi bi-download"></i> Unduh Bukti
            </button>
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
        <a href="{{ route('user.transactions') }}" class="nav-item-btn active">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('user.profile') }}" class="nav-item-btn">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function shareTransaction() {
            const text = `Transaksi OnoPay\n` +
                `ID: {{ $transaction->transaction_id }}\n` +
                `Jumlah: Rp{{ number_format($transaction->amount, 0) }}\n` +
                `Status: {{ $transaction->status }}\n` +
                `Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}`;

            if (navigator.share) {
                navigator.share({
                    title: 'Detail Transaksi OnoPay',
                    text: text
                });
            } else {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Detail transaksi berhasil disalin!');
                });
            }
        }

        function downloadReceipt() {
            alert('Fitur download kuitansi akan segera tersedia');
        }
    </script>
</body>
</html>
