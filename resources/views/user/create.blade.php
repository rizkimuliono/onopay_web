@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<!-- Header Section -->
<div style="background-color: white; padding: 25px 30px; margin: -25px -30px 30px -30px; border-bottom: 2px solid #e6f2ff; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
    <h1 style="color: #003d7a; font-weight: 600; margin: 0 0 5px 0; font-size: 2rem;"><i class="bi bi-plus-circle"></i> Tambah User Baru</h1>
    <p style="color: #666; margin: 0; font-size: 0.95rem;">Silakan isi form di bawah untuk menambah user baru</p>
</div>

<div class="content">
    <!-- Form Card -->
    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
        <div class="card-body p-4">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="phone_number" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Nomor Telepon <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                           id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                           placeholder="Contoh: 081234567890" required>
                    @error('phone_number')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <small style="color: #666;">Format: dimulai dengan 08 dan 10-13 digit</small>
                </div>

                <!-- Nama User -->
                <div class="mb-4">
                    <label for="name" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Nama User <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}"
                           placeholder="Masukkan nama user" required>
                    @error('name')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Email <span style="color: #666;">(Opsional)</span>
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}"
                           placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Saldo Awal -->
                <div class="mb-4">
                    <label for="balance" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Saldo Awal <span style="color: #dc3545;">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #f5f7fa; border: 1px solid #ddd;">Rp</span>
                        <input type="number" class="form-control @error('balance') is-invalid @enderror"
                               id="balance" name="balance" value="{{ old('balance', 0) }}"
                               placeholder="0" min="0" required>
                    </div>
                    @error('balance')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <small style="color: #666;">Hanya angka, minimum 0</small>
                </div>

                <!-- PIN -->
                <div class="mb-4">
                    <label for="pin" class="form-label" style="color: #003d7a; font-weight: 600;">
                        PIN <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="password" class="form-control @error('pin') is-invalid @enderror"
                           id="pin" name="pin" placeholder="Masukkan PIN (6 digit)" required>
                    @error('pin')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <small style="color: #666;">PIN harus 6 digit dan dienkripsi</small>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Status <span style="color: #dc3545;">*</span>
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="mt-5 pt-3 border-top">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color: #0066cc; border: none; padding: 0.6rem 2rem;">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary" style="padding: 0.6rem 2rem;">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0.6rem 0.75rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    }

    .form-label {
        margin-bottom: 0.5rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .input-group-text {
        font-weight: 600;
        color: #003d7a;
    }
</style>
@endsection
