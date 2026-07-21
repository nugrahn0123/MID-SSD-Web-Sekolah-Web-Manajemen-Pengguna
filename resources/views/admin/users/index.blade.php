@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-people me-2"></i>Daftar Pengguna</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
        </a>
    </div>

    {{-- Filter & Search --}}
    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Cari Nama / Email</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Ketik untuk mencari..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Filter Role</label>
                    <select name="role" class="form-select form-select-sm">
                        <option value="">Semua Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Pengguna --}}
    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th class="text-center" style="width:160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-muted small">{{ $users->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                </td>
                                <td><small>{{ $user->email }}</small></td>
                                <td>
                                    <span class="badge bg-primary text-capitalize">
                                        {{ str_replace('_', ' ', $user->role->name) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->status === 'aktif')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                            <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $user->created_at->format('d M Y') }}</small></td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Toggle Status --}}
                                        @if($user->id !== auth()->id())
                                            <form method="POST"
                                                  action="{{ route('admin.users.toggle-status', $user) }}"
                                                  class="d-inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm {{ $user->status === 'aktif' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                        title="{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="bi bi-{{ $user->status === 'aktif' ? 'pause-circle' : 'play-circle' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Hapus --}}
                                            <form method="POST"
                                                  action="{{ route('admin.users.destroy', $user) }}"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
