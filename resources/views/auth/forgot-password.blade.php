@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <h5 class="text-center mb-2 fw-semibold">Lupa Password</h5>
    <p class="text-center text-muted small mb-4">
        Masukkan email Anda dan kami akan mengirimkan link reset password.
    </p>

    @if(session('status'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="nama@sekolah.sch.id"
                    required autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
            <i class="bi bi-send me-1"></i> Kirim Link Reset
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke halaman login
            </a>
        </div>
    </form>
@endsection
