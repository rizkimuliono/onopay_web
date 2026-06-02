@extends('layouts.app')

@section('title', 'Edit Transaksi - OnoPay Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1><i class="bi bi-pencil"></i> Edit Transaksi</h1>
            <p class="text-muted">ID: <code>{{ $transaction->transaction_id }}</code></p>
        </div>
        <div class="col text-end">
            <a href="{{ route('transaction.show', $transaction) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-form-check"></i> Form Edit Transaksi
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Read-Only Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" value="{{ $transaction->user->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="form-control" value="{{ $transaction->user->phone_number }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipe Transaksi</label>
                                <input type="text" class="form-control"
                                       value="@switch($transaction->type)@case('payment')Pembayaran@break@case('topup')Topup@break@case('transfer')Transfer@break@endswitch"
                                       disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nominal</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($transaction->amount, 0) }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control" value="{{ $transaction->description }}" disabled>
                        </div>

                        <hr>

                        <!-- Editable Fields -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Transaksi *</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>
                                    <i class="bi bi-clock"></i> Pending
                                </option>
                                <option value="success" {{ $transaction->status === 'success' ? 'selected' : '' }}>
                                    <i class="bi bi-check-circle"></i> Sukses
                                </option>
                                <option value="failed" {{ $transaction->status === 'failed' ? 'selected' : '' }}>
                                    <i class="bi bi-x-circle"></i> Gagal
                                </option>
                                <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>
                                    <i class="bi bi-slash-circle"></i> Batal
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Admin</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                                      rows="5" placeholder="Tuliskan catatan tentang transaksi ini...">{{ $transaction->notes }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Informasi:</strong> Perubahan status dan catatan akan dicatat. Pastikan perubahan sudah sesuai dengan kondisi transaksi.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('transaction.show', $transaction) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> Riwayat
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Dibuat:</p>
                    <p class="small mb-3">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>

                    @if ($transaction->completed_at)
                        <p class="small text-muted mb-2">Selesai:</p>
                        <p class="small mb-3">{{ $transaction->completed_at->format('d/m/Y H:i:s') }}</p>
                    @endif

                    <p class="small text-muted mb-2">Status Saat Ini:</p>
                    <p class="small">
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

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle"></i> Catatan Penting
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Hanya ubah status jika ada masalah dengan transaksi</li>
                        <li>Cantumkan alasan perubahan di catatan admin</li>
                        <li>Perubahan akan tercatat dalam sistem</li>
                        <li>Hubungi user jika ada pembatalan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
