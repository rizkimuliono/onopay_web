@extends('layouts.app')

@section('title', 'Detail Transaksi - OnoPay Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1><i class="bi bi-arrow-left-right"></i> Detail Transaksi</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('transaction.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('transaction.edit', $transaction) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Informasi Transaksi
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">ID Transaksi</label>
                            <p class="fs-5"><code>{{ $transaction->transaction_id }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Status</label>
                            <p class="fs-5">
                                @switch($transaction->status)
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
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Tipe Transaksi</label>
                            <p class="fs-5">
                                @switch($transaction->type)
                                    @case('payment')
                                        <span class="badge bg-info">Pembayaran</span>
                                        @break
                                    @case('topup')
                                        <span class="badge bg-success">Topup</span>
                                        @break
                                    @case('transfer')
                                        <span class="badge bg-warning">Transfer</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nominal</label>
                            <p class="fs-5" style="font-weight: 700; color: #0066cc;">Rp {{ number_format($transaction->amount, 0) }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Keterangan</label>
                        <p>{{ $transaction->description ?? '- Tidak ada keterangan -' }}</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Dibuat</label>
                            <p>
                                {{ $transaction->created_at->format('d/m/Y H:i:s') }}<br>
                                <small class="text-muted">({{ $transaction->created_at->diffForHumans() }})</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Selesai</label>
                            <p>
                                @if ($transaction->completed_at)
                                    {{ $transaction->completed_at->format('d/m/Y H:i:s') }}<br>
                                    <small class="text-muted">({{ $transaction->completed_at->diffForHumans() }})</small>
                                @else
                                    <span class="text-muted">- Belum dikonfirmasi -</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-chat-left-text"></i> Catatan Admin
                </div>
                <div class="card-body">
                    @if ($transaction->notes)
                        <p>{{ $transaction->notes }}</p>
                    @else
                        <p class="text-muted">- Belum ada catatan -</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Info Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person"></i> Data Pengguna
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0066cc, #003d7a); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>

                    <h6 class="text-center mb-3">{{ $transaction->user->name }}</h6>

                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted" style="width: 40%;">No. HP</td>
                            <td><strong>{{ $transaction->user->phone_number }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><small>{{ $transaction->user->email }}</small></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                @if ($transaction->user->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($transaction->user->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Saldo</td>
                            <td><strong>Rp {{ number_format($transaction->user->balance, 0) }}</strong></td>
                        </tr>
                    </table>

                    @if ($transaction->merchant_code)
                        <hr>
                        <h6>Merchant</h6>
                        <p class="small">{{ $transaction->merchant_code }}</p>
                    @endif
                </div>
            </div>

            <!-- Action -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-wrench"></i> Aksi
                </div>
                <div class="card-body">
                    <a href="{{ route('transaction.edit', $transaction) }}" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-pencil"></i> Edit Transaksi
                    </a>
                    <a href="{{ route('transaction.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
