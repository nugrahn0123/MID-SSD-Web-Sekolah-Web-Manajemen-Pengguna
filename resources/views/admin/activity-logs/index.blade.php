@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Audit Log Aktivitas')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-journal-text me-2"></i>Log Aktivitas Sistem</h4>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-secondary fs-6">Total: {{ $totalAllTime }} entri</span>
            <a href="{{ route('admin.activity-logs.export', request()->only('date_from','date_to')) }}"
               class="btn btn-sm btn-outline-success">
                <i class="bi bi-download me-1"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- Monitoring Panel: statistik hari ini --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="card stat-card border-start border-primary border-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <div class="text-muted small">Aktivitas Hari Ini</div>
                        <div class="fs-3 fw-bold">{{ $totalToday }}</div>
                    </div>
                    <i class="bi bi-activity fs-1 text-primary opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card stat-card border-start border-success border-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <div class="text-muted small">Login Hari Ini</div>
                        <div class="fs-3 fw-bold">
                            {{ $todayStats->where('action','login')->sum('total') }}
                        </div>
                    </div>
                    <i class="bi bi-box-arrow-in-right fs-1 text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card stat-card border-start border-warning border-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <div class="text-muted small">Data Dibuat Hari Ini</div>
                        <div class="fs-3 fw-bold">
                            {{ $todayStats->filter(fn($s) => str_starts_with($s->action, 'create_'))->sum('total') }}
                        </div>
                    </div>
                    <i class="bi bi-plus-circle fs-1 text-warning opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card stat-card border-start border-danger border-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <div class="text-muted small">Data Dihapus Hari Ini</div>
                        <div class="fs-3 fw-bold">
                            {{ $todayStats->filter(fn($s) => str_starts_with($s->action, 'delete_'))->sum('total') }}
                        </div>
                    </div>
                    <i class="bi bi-trash fs-1 text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Breakdown aksi hari ini --}}
    @if($todayStats->isNotEmpty())
    <div class="card stat-card mb-4">
        <div class="card-header bg-white fw-semibold small">
            <i class="bi bi-bar-chart me-1"></i> Rincian Aksi Hari Ini
        </div>
        <div class="card-body py-2">
            <div class="row g-2">
                @foreach($todayStats as $stat)
                <div class="col-auto">
                    @php
                        $color = match(true) {
                            str_contains($stat->action, 'login')  => 'success',
                            str_contains($stat->action, 'logout') => 'secondary',
                            str_starts_with($stat->action, 'delete_') => 'danger',
                            str_starts_with($stat->action, 'create_') => 'primary',
                            str_starts_with($stat->action, 'update_') => 'warning',
                            str_starts_with($stat->action, 'export_'),
                            str_starts_with($stat->action, 'import_') => 'info',
                            default => 'dark',
                        };
                    @endphp
                    <span class="badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-3 py-2">
                        {{ $stat->action }} <span class="fw-bold ms-1">×{{ $stat->total }}</span>
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Filter User</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Filter Aksi</label>
                    <select name="action" class="form-select form-select-sm">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control form-control-sm"
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control form-control-sm"
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Log --}}
    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="text-muted">{{ $logs->firstItem() + $loop->index }}</td>
                                <td class="text-nowrap">
                                    <div>{{ $log->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $log->user?->name ?? '<dihapus>' }}</div>
                                    <small class="text-muted">{{ $log->user?->email }}</small>
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match(true) {
                                            str_contains($log->action, 'login')  => 'success',
                                            str_contains($log->action, 'logout') => 'secondary',
                                            str_contains($log->action, 'delete') => 'danger',
                                            str_contains($log->action, 'create') => 'primary',
                                            str_contains($log->action, 'update') => 'warning',
                                            default => 'info',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} border border-{{ $badgeColor }}-subtle">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>{{ $log->description ?: '-' }}</td>
                                <td><code>{{ $log->ip_address ?? '-' }}</code></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada log aktivitas yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer bg-white">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection