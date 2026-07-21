@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Data Pengguna')

@section('content')
<div class="py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">Edit: {{ $user->name }}</h4>
    </div>

    <div class="card stat-card" style="max-width:600px">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold">
                            Password Baru
                            <small class="text-muted fw-normal">(kosongkan jika tidak berubah)</small>
                        </label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="role_id" class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                        <select id="role_id" name="role_id"
                                class="form-select @error('role_id') is-invalid @enderror" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                            <option value="aktif"    {{ old('status', $user->status) === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
