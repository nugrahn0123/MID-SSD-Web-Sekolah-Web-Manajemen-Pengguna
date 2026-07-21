@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h5 class="text-center mb-4 fw-semibold text-dark">Masuk ke Sistem</h5>

    {{-- Flash status (password reset sukses, dll.) --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('status'))
        <div class="alert alert-info py-2">
            <i class="bi bi-info-circle me-1"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
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
                    autofocus
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required
                >
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Remember Me --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                Lupa password?
            </a>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
        </button>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush
