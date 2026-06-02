@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="content">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #003d7a; font-weight: 600;">Detail User</h1>
            <p style="color: #666; margin: 0;">Nomor Telepon: <strong>{{ $user->phone_number }}</strong></p>
        </div>
        <div>
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning me-2" style="background-color: #ffc107; border: none; color: #333;">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Main Info Card -->
    <div class="row mb-4">
        <!-- User Basic Info -->
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
                <div class="card-body p-4">
                    <h5 style="color: #003d7a; font-weight: 600; margin-bottom: 1.5rem;">
                        <i class="bi bi-person"></i> Informasi User
                    </h5>

                    <div class="mb-3">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Nomor Telepon</label>
                        <p style="color: #003d7a; font-weight: 600; font-size: 1.1rem; margin: 0.25rem 0 0 0;">
                            {{ $user->phone_number }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Nama User</label>
                        <p style="color: #333; font-weight: 500; margin: 0.25rem 0 0 0;">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Email</label>
                        <p style="color: #333; margin: 0.25rem 0 0 0;">
                            {{ $user->email ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-0">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Status</label>
                        <p style="margin: 0.25rem 0 0 0;">
                            @if ($user->status === 'active')
                                <span class="badge bg-success" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                    <i class="bi bi-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                    <i class="bi bi-x-circle"></i> Tidak Aktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance Info -->
        <div class="col-md-6">
            <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px; background: linear-gradient(135deg, #003d7a 0%, #0066cc 100%);">
                <div class="card-body p-4" style="color: white;">
                    <h5 style="font-weight: 600; margin-bottom: 1.5rem;">
                        <i class="bi bi-wallet2"></i> Informasi Saldo
                    </h5>

                    <div class="mb-4">
                        <label style="font-size: 0.85rem; text-transform: uppercase; font-weight: 600; opacity: 0.9;">Saldo Saat Ini</label>
                        <p style="font-weight: 700; font-size: 1.8rem; margin: 0.5rem 0 0 0;">
                            Rp {{ number_format($user->balance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="alert alert-light" style="background-color: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 4px; margin-bottom: 0;">
                        <i class="bi bi-info-circle"></i>
                        <strong>Catatan:</strong> Saldo dapat bertambah dari topup dan berkurang dari pembayaran
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
        <div class="card-body p-4">
            <h5 style="color: #003d7a; font-weight: 600; margin-bottom: 1.5rem;">
                <i class="bi bi-clock-history"></i> Riwayat Sistem
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div style="padding: 1rem; background-color: #f5f7fa; border-radius: 4px; border-left: 3px solid #0066cc;">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">User ID</label>
                        <p style="color: #003d7a; font-weight: 600; margin: 0.25rem 0 0 0;">{{ $user->id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="padding: 1rem; background-color: #f5f7fa; border-radius: 4px; border-left: 3px solid #0066cc;">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Dibuat Pada</label>
                        <p style="color: #333; margin: 0.25rem 0 0 0;">
                            {{ $user->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div style="padding: 1rem; background-color: #f5f7fa; border-radius: 4px; border-left: 3px solid #0066cc;">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Diperbarui</label>
                        <p style="color: #333; margin: 0.25rem 0 0 0;">
                            {{ $user->updated_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div style="padding: 1rem; background-color: #f5f7fa; border-radius: 4px; border-left: 3px solid #0066cc;">
                        <label style="color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">Waktu Tunggu</label>
                        <p style="color: #333; margin: 0.25rem 0 0 0;">
                            {{ $user->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning" style="background-color: #ffc107; border: none; color: #333; padding: 0.6rem 1.5rem;">
            <i class="bi bi-pencil"></i> Edit User
        </a>
        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="padding: 0.6rem 1.5rem;"
                    onclick="return confirm('Yakin akan menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                <i class="bi bi-trash"></i> Hapus User
            </button>
        </form>
        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary" style="padding: 0.6rem 1.5rem;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>
@endsection
