@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h5 class="text-center mb-4 fw-semibold">Reset Password</h5>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $email ?? '') }}"
                required autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password Baru</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Minimal 8 karakter"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password baru"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
            <i class="bi bi-shield-check me-1"></i> Reset Password
        </button>
    </form>
@endsection
