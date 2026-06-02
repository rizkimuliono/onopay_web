@extends('layouts.app')

@section('title', 'Daftar Transaksi - OnoPay Admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="bi bi-arrow-left-right"></i> Daftar Transaksi</h1>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel"></i> Filter & Pencarian
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('transaction.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari No. HP, Nama, atau ID Transaksi..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select class="form-select" name="type">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Pembayaran</option>
                        <option value="topup" {{ request('type') === 'topup' ? 'selected' : '' }}>Topup</option>
                        <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">-- Pilih Status --</option>
                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Sukses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-list-check"></i> Transaksi
            <span class="badge bg-secondary float-end">{{ $transactions->total() }} data</span>
        </div>
        <div class="card-body">
            @if ($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Pengguna</th>
                                <th>Tipe</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $tx)
                                <tr>
                                    <td>
                                        <code style="font-size: 0.85rem;">{{ $tx->transaction_id }}</code>
                                    </td>
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
                                    <td>
                                        <strong>Rp {{ number_format($tx->amount, 0) }}</strong>
                                    </td>
                                    <td>
                                        @switch($tx->status)
                                            @case('success')
                                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Sukses</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Gagal</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning"><i class="bi bi-clock"></i> Pending</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-secondary"><i class="bi bi-slash-circle"></i> Batal</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <small>
                                            {{ $tx->created_at->format('d/m/Y') }}<br>
                                            {{ $tx->created_at->format('H:i:s') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('transaction.show', $tx) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('transaction.edit', $tx) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav class="d-flex justify-content-center mt-4">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Transaksi tidak ditemukan
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
