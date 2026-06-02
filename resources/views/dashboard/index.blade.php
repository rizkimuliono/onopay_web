@extends('layouts.app')

@section('title', 'Dashboard - OnoPay Admin')

@section('content')
<!-- Header Section -->
<div style="background-color: white; padding: 25px 30px; margin: -25px -30px 30px -30px; border-bottom: 2px solid #e6f2ff; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
    <h1 style="color: #003d7a; font-weight: 600; margin: 0; font-size: 2rem;"><i class="bi bi-speedometer2"></i> Dashboard</h1>
</div>

<div class="container-fluid">
    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6><i class="bi bi-people"></i> Total Users</h6>
                <div class="value">{{ number_format($totalUsers) }}</div>
                <small class="text-success">{{ number_format($activeUsers) }} aktif</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6><i class="bi bi-wallet2"></i> Total Saldo</h6>
                <div class="value">Rp {{ number_format($totalBalance, 0) }}</div>
                <small class="text-muted">Di semua user</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6><i class="bi bi-arrow-left-right"></i> Total Transaksi</h6>
                <div class="value">{{ number_format($totalTransactions) }}</div>
                <small class="text-muted">Semua waktu</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6><i class="bi bi-calendar-day"></i> Transaksi Hari Ini</h6>
                <div class="value">{{ number_format($todayTransactions) }}</div>
                <small class="text-info">Rp {{ number_format($todayAmount, 0) }}</small>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card w-100">
        <div class="card-header">
            <i class="bi bi-list-check"></i> Transaksi Terbaru
        </div>
        <div class="card-body p-0">
            @if ($recentTransactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 w-100">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>User</th>
                                <th>Tipe</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTransactions as $tx)
                                <tr>
                                    <td><code>{{ $tx->transaction_id }}</code></td>
                                    <td>
                                        <strong>{{ $tx->user->name }}</strong><br>
                                        <small class="text-muted">{{ $tx->user->phone_number }}</small>
                                    </td>
                                    <td>
                                        @switch($tx->type)
                                            @case('payment')
                                                <span class="badge bg-info">Pembayaran</span>
                                                @break
                                            @case('topup')
                                                <span class="badge bg-success">Topup</span>
                                                @break
                                            @case('transfer')
                                                <span class="badge bg-warning">Transfer</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($tx->type) }}</span>
                                        @endswitch
                                    </td>
                                    <td><strong>Rp {{ number_format($tx->amount, 0) }}</strong></td>
                                    <td>
                                        @switch($tx->status)
                                            @case('success')
                                                <span class="badge bg-success">Sukses</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger">Gagal</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-secondary">Batal</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td><small>{{ $tx->created_at->format('d/m/Y H:i') }}</small></td>
                                    <td>
                                        <a href="{{ route('transaction.show', $tx) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info m-3">
                    <i class="bi bi-info-circle"></i> Belum ada transaksi
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4 text-center text-muted">
        <small>OnoPay Admin Panel • Terakhir diperbarui: {{ now()->format('d/m/Y H:i:s') }}</small>
    </div>
</div>
@endsection
