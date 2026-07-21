@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="py-4">
    {{-- Header Selamat Datang --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Selamat datang, {{ $user->name }} 👋</h4>
        <p class="text-muted">
            Anda login sebagai
            <span class="badge bg-primary text-capitalize">{{ str_replace('_', ' ', $user->role->name) }}</span>
            — {{ now()->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>

    {{-- ── Dashboard Admin ──────────────────────────────────────────────── --}}
    @if($user->hasRole('admin'))
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card border-start border-primary border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Pengguna</div>
                            <div class="fs-3 fw-bold">{{ \App\Models\User::count() }}</div>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card border-start border-success border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Pengguna Aktif</div>
                            <div class="fs-3 fw-bold">{{ \App\Models\User::where('status','aktif')->count() }}</div>
                        </div>
                        <i class="bi bi-person-check-fill fs-1 text-success opacity-25"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card border-start border-warning border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Role</div>
                            <div class="fs-3 fw-bold">{{ \App\Models\Role::count() }}</div>
                        </div>
                        <i class="bi bi-shield-fill fs-1 text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card border-start border-info border-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Siswa</div>
                            <div class="fs-3 fw-bold">{{ \App\Models\Student::count() }}</div>
                        </div>
                        <i class="bi bi-mortarboard fs-1 text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-diagram-3 me-1"></i> Ringkasan Modul Sekolah
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Data Kelas</span>
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\SchoolClass::count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Jurnal Mengajar</span>
                            <span class="badge bg-success rounded-pill">{{ \App\Models\TeachingJournal::count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Catatan BK</span>
                            <span class="badge bg-warning rounded-pill">{{ \App\Models\BkCase::count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Log Hari Ini</span>
                            <span class="badge bg-info rounded-pill">{{ \App\Models\ActivityLog::whereDate('created_at', today())->count() }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right me-1"></i> Kelola Data Siswa
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="bi bi-clock-history me-1"></i> Aktivitas Terbaru
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach(\App\Models\ActivityLog::with('user')->latest()->take(6)->get() as $log)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold">{{ $log->user?->name ?? 'N/A' }}</span>
                                        <br><small class="text-muted">{{ $log->action }}</small>
                                    </div>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-right me-1"></i> Lihat Semua Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Dashboard non-Admin ──────────────────────────────────────────── --}}
    @if(!$user->hasRole('admin'))
        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <div class="card stat-card text-center p-4">
                    <i class="bi bi-person-circle fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <span class="badge bg-primary text-capitalize fs-6">
                        {{ str_replace('_', ' ', $user->role->name) }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-lg-8">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-grid me-1"></i> Menu Saya
                        </h5>
                        <p class="text-muted">
                            Fitur-fitur di bawah ini tersedia sesuai peran Anda sebagai
                            <strong class="text-capitalize">{{ str_replace('_', ' ', $user->role->name) }}</strong>.
                            Modul inti yang sesuai role Anda sudah aktif, sedangkan modul lanjutan tetap dapat diintegrasikan melalui API pusat pengguna.
                        </p>
                        <div class="alert alert-info mb-0">
                            @if($user->hasRole(['guru', 'wali_kelas']))
                                <a href="{{ route('journals.index') }}" class="btn btn-sm btn-outline-primary">Buka Jurnal Mengajar</a>
                            @elseif($user->hasRole('guru_bk'))
                                <a href="{{ route('bk-cases.index') }}" class="btn btn-sm btn-outline-primary">Buka Modul BK</a>
                            @elseif($user->hasRole('wali_kelas'))
                                <a href="{{ route('students.overview') }}" class="btn btn-sm btn-outline-primary">Lihat Data Siswa</a>
                            @else
                                <i class="bi bi-info-circle me-1"></i>
                                Dashboard ini menunjukkan akses role Anda pada sistem sekolah terintegrasi.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
