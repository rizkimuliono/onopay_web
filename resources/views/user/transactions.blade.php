<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - OnoPay</title>
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

        .transaction-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s ease;
        }

        .transaction-link:last-child {
            border-bottom: none;
        }

        .transaction-link:hover {
            background-color: #f9f9f9;
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-success {
            background: #d1e7dd;
            color: #0a3622;
        }

        .status-pending {
            background: #fff3cd;
            color: #664d03;
        }

        .status-failed {
            background: #f8d7da;
            color: #842029;
        }

        .filters {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-btn {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .filter-btn.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .filter-btn:hover {
            border-color: var(--primary-blue);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 15px;
        }

        .empty-state-text {
            color: #999;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
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
        <!-- Header -->
        <div style="margin-bottom: 20px;">
            <h2 style="color: var(--primary-dark); font-weight: 700; margin-bottom: 5px;">Riwayat Transaksi</h2>
            <p style="color: #999; margin: 0;">Total: <strong>{{ $transactions->total() }}</strong> transaksi</p>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div style="font-size: 0.85rem; color: #999; margin-bottom: 10px;">Filter Riwayat</div>
            <button class="filter-btn active" onclick="filterTransactions('all')">Semua</button>
            <button class="filter-btn" onclick="filterTransactions('success')">Berhasil</button>
            <button class="filter-btn" onclick="filterTransactions('pending')">Pending</button>
            <button class="filter-btn" onclick="filterTransactions('failed')">Gagal</button>
        </div>

        <!-- Transactions List -->
        @if ($transactions->count() > 0)
            <div class="card">
                @foreach ($transactions as $tx)
                    <a href="{{ route('user.transaction-detail', $tx->transaction_id) }}" class="transaction-link">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <div class="transaction-icon" style="background: @if($tx->type === 'payment') #0066cc @elseif($tx->type === 'topup') #28a745 @else #ffc107 @endif;">
                                <i class="bi @if($tx->type === 'payment') bi-arrow-up-right @elseif($tx->type === 'topup') bi-arrow-down-left @else bi-arrow-left-right @endif"></i>
                            </div>
                            <div class="transaction-info">
                                <div class="transaction-type">
                                    @if ($tx->type === 'payment')
                                        Pembayaran Outgoing
                                    @elseif ($tx->type === 'topup')
                                        Top-up Saldo
                                    @else
                                        {{ ucfirst($tx->type) }}
                                    @endif
                                </div>
                                <div class="transaction-time">
                                    {{ $tx->created_at->format('d M Y, H:i') }}
                                </div>
                                <small style="color: #999; display: block; margin-top: 3px;">
                                    {{ $tx->description ?? 'Transaksi OnoPay' }}
                                </small>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div class="transaction-amount">
                                @if($tx->type === 'payment')
                                    -Rp {{ number_format($tx->amount, 0) }}
                                @else
                                    +Rp {{ number_format($tx->amount, 0) }}
                                @endif
                            </div>
                            <span class="status-badge
                                @if($tx->status === 'success') status-success
                                @elseif($tx->status === 'pending') status-pending
                                @else status-failed
                                @endif">
                                @if($tx->status === 'success') ✓ Berhasil
                                @elseif($tx->status === 'pending') ⏱ Pending
                                @else ✗ Gagal @endif
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <nav aria-label="Transaction pagination">
                    <ul class="pagination">
                        @if ($transactions->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">← Sebelumnya</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $transactions->previousPageUrl() }}">← Sebelumnya</a></li>
                        @endif

                        @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                            @if ($page == $transactions->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($transactions->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $transactions->nextPageUrl() }}">Selanjutnya →</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Selanjutnya →</span></li>
                        @endif
                    </ul>
                </nav>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <div class="empty-state-text">
                    <p style="margin: 0;"><strong>Belum ada riwayat transaksi</strong></p>
                    <small style="color: #bbb;">Mulai transaksi Anda dengan menekan tombol "Bayar" atau "Minta Bayar"</small>
                </div>
            </div>
        @endif
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
        function filterTransactions(type) {
            // Update button states
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Filter logic can be added here
            alert('Filter ' + type + ' - Fitur akan segera diimplementasikan');
        }
    </script>
</body>
</html>
