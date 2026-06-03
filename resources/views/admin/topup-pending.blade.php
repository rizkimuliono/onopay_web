<!-- Admin Pending Topups Management Page -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Top Up - OnoPay Admin</title>
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

        .badge-pending {
            background: #ffc107;
            color: #000;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-failed {
            background: #dc3545;
            color: white;
        }

        .btn-approve {
            background: #28a745;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-approve:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }

        .btn-reject {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 5px;
        }

        .btn-reject:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #999;
            margin-top: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 15px;
        }

        .modal-header {
            background: var(--primary-blue);
            color: white;
            border: none;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
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
        <a href="{{ route('admin.topup-pending') }}" class="sidebar-menu-item active">
            <i class="bi bi-clock-history"></i> Pending Topups
        </a>
        <a href="{{ route('admin.balance-verification') }}" class="sidebar-menu-item">
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
            <i class="bi bi-clock-history"></i> Kelola Topup Pending
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ $pendingCount ?? 0 }}</div>
                <div class="stat-label">Topup Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">Rp {{ number_format($pendingAmount ?? 0, 0) }}</div>
                <div class="stat-label">Total Amount</div>
            </div>
        </div>

        <!-- Pending Topups Table -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-check"></i> Daftar Topup Menunggu Verifikasi
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Phone Number</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingTopups ?? [] as $topup)
                            <tr>
                                <td>
                                    <strong>{{ $topup->transaction_id }}</strong>
                                </td>
                                <td>{{ $topup->user->phone_number }}</td>
                                <td>{{ $topup->user->name }}</td>
                                <td><strong>Rp {{ number_format($topup->amount, 0) }}</strong></td>
                                <td>
                                    <span class="badge badge-pending">
                                        <i class="bi bi-clock"></i> Pending
                                    </span>
                                </td>
                                <td>{{ $topup->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        @csrf
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#approveModal{{ $topup->id }}" class="btn-approve">
                                            <i class="bi bi-check"></i> Approve
                                        </a>
                                        <form action="{{ route('admin.topup-reject', $topup->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Reject topup ini?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn-reject">
                                                <i class="bi bi-x"></i> Reject
                                            </button>
                                        </form>
                                    </form>
                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $topup->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve Topup</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Transaction ID:</strong> {{ $topup->transaction_id }}</p>
                                            <p><strong>User:</strong> {{ $topup->user->name }} ({{ $topup->user->phone_number }})</p>
                                            <p><strong>Amount:</strong> Rp {{ number_format($topup->amount, 0) }}</p>
                                            <p>Approve topup ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.topup-approve', $topup->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check"></i> Approve
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada topup yang menunggu verifikasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
