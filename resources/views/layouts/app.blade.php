<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Web Sekolah</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a2035 0%, #1c3461 100%);
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: .5rem 1rem;
            border-radius: .375rem;
            margin: 2px 8px;
            font-size: .9rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.15);
        }
        .sidebar .nav-section {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            padding: .75rem 1rem .25rem;
        }
        .sidebar-brand {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }
        .top-navbar {
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: .75rem;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }

        /* Badge role */
        .badge-role { font-size: .75rem; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
<div class="sidebar">
    <div class="sidebar-brand text-center">
        <div class="text-white fw-bold fs-5">
            <i class="bi bi-mortarboard-fill me-1 text-warning"></i> Web Sekolah
        </div>
        <div class="mt-2">
            <span class="badge bg-primary badge-role text-capitalize">
                {{ str_replace('_', ' ', auth()->user()->role->name) }}
            </span>
        </div>
        <small class="text-white-50 d-block mt-1">{{ auth()->user()->name }}</small>
    </div>

    <ul class="nav flex-column py-2">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        {{-- Menu khusus Admin --}}
        @if(auth()->user()->hasRole('admin'))
            <li><div class="nav-section">Manajemen</div></li>
            <li class="nav-item">
                <a href="{{ route('admin.roles.index') }}"
                   class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock me-2"></i> Kelola Role
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Kelola Pengguna
                </a>
            </li>
            <li><div class="nav-section">Kesiswaan</div></li>
            <li class="nav-item">
                <a href="{{ route('admin.classes.index') }}"
                   class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3 me-2"></i> Kelola Kelas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.students.index') }}"
                   class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard me-2"></i> Data Siswa
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.activity-logs.index') }}"
                   class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text me-2"></i> Log Aktivitas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.monitoring.index') }}"
                   class="nav-link {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
                    <i class="bi bi-activity me-2"></i> System Monitor
                </a>
            </li>
        @endif

        {{-- Menu Guru / Wali Kelas --}}
        @if(auth()->user()->hasRole(['guru', 'wali_kelas']))
            <li><div class="nav-section">Akademik</div></li>
            <li class="nav-item">
                <a href="{{ route('journals.index') }}" class="nav-link {{ request()->routeIs('journals.*') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i> Jurnal Mengajar
                </a>
            </li>
        @endif

        {{-- Menu Wali Kelas --}}
        @if(auth()->user()->hasRole('wali_kelas'))
            <li class="nav-item">
                <a href="{{ route('students.overview') }}" class="nav-link {{ request()->routeIs('students.overview') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill me-2"></i> Data Kelas
                </a>
            </li>
        @endif

        {{-- Menu Guru BK --}}
        @if(auth()->user()->hasRole('guru_bk'))
            <li><div class="nav-section">Bimbingan Konseling</div></li>
            <li class="nav-item">
                <a href="{{ route('bk-cases.index') }}" class="nav-link {{ request()->routeIs('bk-cases.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-heart me-2"></i> Data Konseling
                </a>
            </li>
        @endif

        {{-- Menu Kepala Sekolah --}}
        @if(auth()->user()->hasRole('kepala_sekolah'))
            <li><div class="nav-section">Monitoring</div></li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white-50">
                    <i class="bi bi-bar-chart-line me-2"></i> Laporan & Statistik
                    <span class="badge bg-secondary ms-1 float-end" style="font-size:.65rem">Modul Lain</span>
                </a>
            </li>
        @endif

        {{-- Menu Siswa --}}
        @if(auth()->user()->hasRole('siswa'))
            <li><div class="nav-section">Akademik</div></li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white-50">
                    <i class="bi bi-table me-2"></i> Nilai & Jadwal
                    <span class="badge bg-secondary ms-1 float-end" style="font-size:.65rem">Modul Lain</span>
                </a>
            </li>
        @endif

        {{-- Menu Orang Tua --}}
        @if(auth()->user()->hasRole('orang_tua'))
            <li><div class="nav-section">Monitoring Anak</div></li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white-50">
                    <i class="bi bi-eye me-2"></i> Perkembangan Anak
                    <span class="badge bg-secondary ms-1 float-end" style="font-size:.65rem">Modul Lain</span>
                </a>
            </li>
        @endif
    </ul>
</div>

<!-- ── Main Content ──────────────────────────────────────────────────────── -->
<div class="main-content">
    <!-- Top Navbar -->
    <nav class="navbar top-navbar px-4 py-2">
        <span class="navbar-text text-muted">@yield('page-title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-3 ms-auto">
            <span class="text-muted small d-none d-md-inline">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="px-4 pb-5">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
