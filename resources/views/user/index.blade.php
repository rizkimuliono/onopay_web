@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="content">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: #003d7a; font-weight: 600;">Data User</h1>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <!-- Alert Messages -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> Ada kesalahan, silakan periksa kembali
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card mb-4" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
        <div class="card-body">
            <form action="{{ route('user.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="phone" class="form-label" style="color: #003d7a; font-weight: 500;">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           value="{{ request('phone') }}" placeholder="Cari nomor telepon...">
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label" style="color: #003d7a; font-weight: 500;">Nama User</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ request('name') }}" placeholder="Cari nama...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label" style="color: #003d7a; font-weight: 500;">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">-- Semua Status --</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color: transparent;">Search</label>
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f5f7fa; border-bottom: 2px solid #e6f2ff;">
                        <tr>
                            <th style="color: #003d7a; font-weight: 600;">No</th>
                            <th style="color: #003d7a; font-weight: 600;">Nomor Telepon</th>
                            <th style="color: #003d7a; font-weight: 600;">Nama User</th>
                            <th style="color: #003d7a; font-weight: 600;">Email</th>
                            <th style="color: #003d7a; font-weight: 600;">Saldo</th>
                            <th style="color: #003d7a; font-weight: 600;">Status</th>
                            <th style="color: #003d7a; font-weight: 600; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr style="border-bottom: 1px solid #e6f2ff;">
                                <td style="color: #333;">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                                <td>
                                    <span style="color: #0066cc; font-weight: 500;">{{ $user->phone_number }}</span>
                                </td>
                                <td style="color: #333;">
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td style="color: #666;">{{ $user->email ?? '-' }}</td>
                                <td style="color: #0066cc; font-weight: 600;">
                                    Rp {{ number_format($user->balance, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                            <i class="bi bi-x-circle"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info"
                                           title="Lihat Detail" style="background-color: #0066cc; border: none;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning"
                                           title="Edit" style="background-color: #ffc107; border: none; color: #333;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin akan menghapus user ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                    Tidak ada data user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <nav aria-label="Page navigation" class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </nav>
            @endif
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f7fa;
    }

    .btn-group .btn {
        border-radius: 4px;
        margin: 0 2px;
        padding: 0.375rem 0.75rem;
    }

    .btn-group .btn:hover {
        opacity: 0.9;
    }
</style>
@endsection
