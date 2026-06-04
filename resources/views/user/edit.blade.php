@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<!-- Header Section -->
<div style="background-color: white; padding: 25px 30px; margin: -25px -30px 30px -30px; border-bottom: 2px solid #e6f2ff; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
    <h1 style="color: #003d7a; font-weight: 600; margin: 0 0 5px 0; font-size: 2rem;"><i class="bi bi-pencil-square"></i> Edit User</h1>
    <p style="color: #666; margin: 0; font-size: 0.95rem;">Nomor Telepon: <strong>{{ $user->phone_number }}</strong></p>
</div>

<div class="content">
    <!-- Form Card -->
    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
        <div class="card-body p-4">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nomor Telepon (Read Only) -->
                <div class="mb-4">
                    <label for="phone_number" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Nomor Telepon
                    </label>
                    <input type="text" class="form-control"
                           id="phone_number" value="{{ $user->phone_number }}" readonly
                           style="background-color: #f5f7fa; cursor: not-allowed;">
                    <small style="color: #666;">Nomor telepon tidak dapat diubah</small>
                </div>

                <!-- Nama User -->
                <div class="mb-4">
                    <label for="name" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Nama User <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $user->name) }}"
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
                           id="email" name="email" value="{{ old('email', $user->email) }}"
                           placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Saldo -->
                <div class="mb-4">
                    <label for="balance" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Saldo <span style="color: #dc3545;">*</span>
                        </label>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label" style="color: #003d7a; font-weight: 600;">
                            Password <span style="color: #666;">(Opsional)</span>
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small style="color: #666;">Minimal 8 karakter. Kosongkan jika tidak ingin diubah.</small>
                    </div>

                    <!-- Saldo -->
                    <div class="mb-4">
                        <label for="balance" class="form-label" style="color: #003d7a; font-weight: 600;">
                            Saldo <span style="color: #dc3545;">*</span>
                        </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #f5f7fa; border: 1px solid #ddd;">Rp</span>
                        <input type="number" class="form-control @error('balance') is-invalid @enderror"
                               id="balance" name="balance" value="{{ old('balance', $user->balance) }}"
                               placeholder="0" min="0" required>
                    </div>
                    @error('balance')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <small style="color: #666;">Hanya angka, minimum 0</small>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label" style="color: #003d7a; font-weight: 600;">
                        Status <span style="color: #dc3545;">*</span>
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Info Card -->
                <div class="alert alert-info" style="background-color: #e6f2ff; border: 1px solid #0066cc; color: #003d7a; border-radius: 4px;">
                    <i class="bi bi-info-circle"></i> <strong>Informasi Tambahan:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem; padding-left: 0;">
                        <li>Dibuat: {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</li>
                        <li>Diperbarui: {{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="mt-5 pt-3 border-top">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color: #0066cc; border: none; padding: 0.6rem 2rem;">
                            <i class="bi bi-check-circle"></i> Perbarui
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

    .alert-info ul li {
        margin-bottom: 0.25rem;
    }
</style>
@endsection
