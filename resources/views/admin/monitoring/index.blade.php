@extends('layouts.app')

@section('title', 'System Monitor')
@section('page-title', 'System Monitor')

{{-- Auto-refresh setiap 30 detik --}}
@push('head')
<meta http-equiv="refresh" content="30">
@endpush

@section('content')
<div class="py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="bi bi-activity me-2 text-success"></i>System Monitor</h4>
            <small class="text-muted">Auto-refresh setiap 30 detik &bull; Terakhir: {{ now()->format('H:i:s') }}</small>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
                <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i> Sistem Online
            </span>
            @if($uptimeSeconds)
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                <i class="bi bi-clock me-1"></i> Uptime: {{ gmdate('H:i:s', $uptimeSeconds) }}
            </span>
            @endif
        </div>
    </div>

    {{-- ── Row 1: Server Metrics ─────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">

        {{-- PHP Memory --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase">PHP Memory</div>
                            <div class="fs-4 fw-bold mt-1">{{ number_format($memUsed / 1024 / 1024, 1) }} MB</div>
                            <div class="text-muted small">Peak: {{ number_format($memPeak / 1024 / 1024, 1) }} MB / Limit: {{ number_format($memLimit / 1024 / 1024, 0) }} MB</div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                             style="width:48px;height:48px">
                            <i class="bi bi-memory fs-4 text-primary"></i>
                        </div>
                    </div>
                    <div class="progress" style="height:6px">
                        <div class="progress-bar bg-{{ $memUsedPct > 80 ? 'danger' : ($memUsedPct > 60 ? 'warning' : 'primary') }}"
                             style="width:{{ $memUsedPct }}%"></div>
                    </div>
                    <small class="text-muted">{{ $memUsedPct }}% terpakai</small>
                </div>
            </div>
        </div>

        {{-- Disk --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase">Disk Storage</div>
                            <div class="fs-4 fw-bold mt-1">{{ number_format($diskUsed / 1024 / 1024 / 1024, 1) }} GB</div>
                            <div class="text-muted small">
                                Bebas: {{ number_format($diskFree / 1024 / 1024 / 1024, 1) }} GB
                                / Total: {{ number_format($diskTotal / 1024 / 1024 / 1024, 1) }} GB
                            </div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10"
                             style="width:48px;height:48px">
                            <i class="bi bi-hdd fs-4 text-warning"></i>
                        </div>
                    </div>
                    <div class="progress" style="height:6px">
                        <div class="progress-bar bg-{{ $diskUsedPct > 85 ? 'danger' : ($diskUsedPct > 65 ? 'warning' : 'success') }}"
                             style="width:{{ $diskUsedPct }}%"></div>
                    </div>
                    <small class="text-muted">{{ $diskUsedPct }}% terpakai</small>
                </div>
            </div>
        </div>

        {{-- CPU Load --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase">CPU Load Avg</div>
                            @if($cpuLoad)
                                <div class="fs-4 fw-bold mt-1">{{ number_format($cpuLoad[0], 2) }}</div>
                                <div class="text-muted small">5m: {{ number_format($cpuLoad[1], 2) }} &bull; 15m: {{ number_format($cpuLoad[2], 2) }}</div>
                                @php $loadPct = min(round($cpuLoad[0] * 100), 100); @endphp
                                <div class="progress mt-2" style="height:6px">
                                    <div class="progress-bar bg-{{ $loadPct > 80 ? 'danger' : ($loadPct > 50 ? 'warning' : 'success') }}"
                                         style="width:{{ $loadPct }}%"></div>
                                </div>
                            @else
                                <div class="fs-4 fw-bold mt-1 text-muted">N/A</div>
                                <div class="text-muted small">sys_getloadavg() tidak tersedia di Windows. Gunakan Task Manager atau htop di Linux.</div>
                            @endif
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10"
                             style="width:48px;height:48px">
                            <i class="bi bi-cpu fs-4 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- App Stats --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-muted small fw-semibold text-uppercase">Aktivitas Aplikasi</div>
                            <div class="fs-4 fw-bold mt-1">{{ $activeUsers }} <small class="fs-6 fw-normal">aktif</small></div>
                            <div class="text-muted small">Pengguna aktif 15 menit terakhir</div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10"
                             style="width:48px;height:48px">
                            <i class="bi bi-people fs-4 text-success"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Request hari ini</small>
                        <span class="badge bg-info-subtle text-info">{{ $requestsToday }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted">PHP {{ PHP_VERSION }}</small>
                        <span class="badge bg-secondary-subtle text-secondary">{{ PHP_OS_FAMILY }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 2: vCPU Architecture ─────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold border-bottom">
            <i class="bi bi-diagram-3 me-2 text-primary"></i>
            Arsitektur vCPU — Status Per Node Layanan
            <span class="badge bg-primary-subtle text-primary ms-2">6 vCPU</span>
        </div>
        <div class="card-body">

            {{-- Load Balancer di atas --}}
            <div class="text-center mb-3">
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2 border border-2 border-secondary rounded-pill bg-secondary bg-opacity-10">
                    <i class="bi bi-globe2 fs-5 text-secondary"></i>
                    <span class="fw-semibold text-secondary">Internet / Client Request</span>
                </div>
                <div class="text-muted" style="font-size:.75rem;margin-top:2px">↓</div>
            </div>

            {{-- vCPU 6 Load Balancer --}}
            @php $lb = collect($vcpus)->firstWhere('id', 6); @endphp
            <div class="text-center mb-2">
                <div class="d-inline-block">
                    @include('admin.monitoring._vcpu-card', ['vcpu' => $lb, 'wide' => true])
                </div>
                <div class="text-muted" style="font-size:.75rem;margin-top:2px">↓ Distribute requests</div>
            </div>

            {{-- vCPU 1–4 (web services) --}}
            <div class="row g-3 justify-content-center mb-3">
                @foreach(collect($vcpus)->whereIn('id', [1,2,3,4]) as $vcpu)
                <div class="col-sm-6 col-lg-3">
                    @include('admin.monitoring._vcpu-card', ['vcpu' => $vcpu, 'wide' => false])
                </div>
                @endforeach
            </div>

            {{-- Arrow down --}}
            <div class="text-center text-muted mb-2" style="font-size:.75rem">↓ semua modul terhubung ke satu database</div>

            {{-- vCPU 5 Database --}}
            @php $db = collect($vcpus)->firstWhere('id', 5); @endphp
            <div class="text-center">
                <div class="d-inline-block" style="min-width:260px">
                    @include('admin.monitoring._vcpu-card', ['vcpu' => $db, 'wide' => true])
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 3: Database Table Stats ──────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-bottom">
                    <i class="bi bi-table me-1 text-warning"></i> Ukuran Tabel Database
                </div>
                <div class="card-body p-0">
                    @if($tableSizes)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Tabel</th>
                                    <th class="text-end">Baris</th>
                                    <th class="text-end">Ukuran (KB)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tableSizes as $t)
                                <tr>
                                    <td><code>{{ $t['name'] }}</code></td>
                                    <td class="text-end">{{ number_format($t['row_count']) }}</td>
                                    <td class="text-end">{{ number_format($t['size_kb'], 1) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-3 text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Informasi ukuran tabel hanya tersedia pada MySQL / MariaDB.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-bottom">
                    <i class="bi bi-bar-chart me-1 text-info"></i> Ringkasan Data Aplikasi
                </div>
                <div class="card-body">
                    @foreach([
                        ['label' => 'Total Pengguna', 'value' => $dbStats['users'], 'icon' => 'bi-people', 'color' => 'primary'],
                        ['label' => 'Total Siswa', 'value' => $dbStats['students'], 'icon' => 'bi-mortarboard', 'color' => 'info'],
                        ['label' => 'Total Kelas', 'value' => $dbStats['classes'], 'icon' => 'bi-diagram-3', 'color' => 'success'],
                        ['label' => 'Jurnal Mengajar', 'value' => $dbStats['journals'], 'icon' => 'bi-book', 'color' => 'warning'],
                        ['label' => 'Catatan BK', 'value' => $dbStats['bk_cases'], 'icon' => 'bi-clipboard2-heart', 'color' => 'danger'],
                        ['label' => 'Total Log Aktivitas', 'value' => $dbStats['logs'], 'icon' => 'bi-journal-text', 'color' => 'secondary'],
                    ] as $stat)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small"><i class="bi {{ $stat['icon'] }} me-2 text-{{ $stat['color'] }}"></i>{{ $stat['label'] }}</span>
                        <span class="fw-bold text-{{ $stat['color'] }}">{{ number_format($stat['value']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 4: Recent Error Log ───────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold border-bottom d-flex justify-content-between">
            <span><i class="bi bi-exclamation-triangle me-1 text-danger"></i> Error Log Terbaru</span>
            <small class="text-muted fw-normal">storage/logs/laravel.log</small>
        </div>
        <div class="card-body p-0">
            @if($recentErrors)
                <div style="max-height:220px;overflow-y:auto;background:#1e1e2e">
                    @foreach($recentErrors as $err)
                    <div class="px-3 py-1 border-bottom border-secondary"
                         style="font-family:monospace;font-size:.72rem;color:#f1958a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        {{ $err }}
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-check-circle-fill text-success fs-3 mb-2 d-block"></i>
                    Tidak ada error yang tercatat. Sistem berjalan normal.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection