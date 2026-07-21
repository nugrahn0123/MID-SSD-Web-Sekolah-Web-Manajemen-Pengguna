@extends('layouts.app')

@section('title', 'Kelola Role')
@section('page-title', 'Manajemen Role')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-shield-lock me-2"></i>Daftar Role</h4>
            <p class="text-muted mb-0">Role bawaan sistem dipakai untuk login, redirect dashboard, dan pembatasan akses RBAC.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Role
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Role</div>
                    <div class="fs-3 fw-bold">{{ $roles->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-success border-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Role Sistem</div>
                    <div class="fs-3 fw-bold">{{ $roles->filter(fn ($role) => $role->isSystemRole())->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-warning border-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Role Kustom</div>
                    <div class="fs-3 fw-bold">{{ $roles->filter(fn ($role) => ! $role->isSystemRole())->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Nama Role</th>
                            <th>Deskripsi</th>
                            <th>Jumlah User</th>
                            <th>Tipe</th>
                            <th class="text-center" style="width:150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $role->name }}</div>
                                    <small class="text-muted text-capitalize">{{ str_replace('_', ' ', $role->name) }}</small>
                                </td>
                                <td>{{ $role->description ?: '-' }}</td>
                                <td><span class="badge bg-primary rounded-pill">{{ $role->users_count }}</span></td>
                                <td>
                                    @if($role->isSystemRole())
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">Sistem</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Kustom</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if(! $role->isSystemRole())
                                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Hapus role {{ addslashes($role->name) }}?')">
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
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data role.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection