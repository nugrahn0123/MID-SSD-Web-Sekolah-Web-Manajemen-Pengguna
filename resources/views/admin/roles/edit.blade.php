@extends('layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">Edit Role: {{ $role->name }}</h4>
    </div>

    <div class="card stat-card" style="max-width: 640px;">
        <div class="card-body p-4">
            @if($role->isSystemRole())
                <div class="alert alert-warning">
                    Role ini adalah role bawaan sistem. Nama role dikunci agar tidak merusak middleware RBAC dan redirect dashboard.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Role <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $role->name) }}" {{ $role->isSystemRole() ? 'readonly' : '' }} required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $role->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection