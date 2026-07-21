@extends('layouts.app')

@section('title', 'Rekap BK')
@section('page-title', 'Rekap BK dan Konseling')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-journal-text me-2"></i>Rekap BK</h4>
        <a href="{{ route('bk-cases.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('bk-cases.recap') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Siswa</label>
                    <select name="student_id" class="form-select form-select-sm">
                        <option value="">Semua Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kelas</label>
                    <select name="class_id" class="form-select form-select-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jenis Kasus</label>
                    <select name="case_type" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['konseling', 'pelanggaran', 'prestasi'] as $type)
                            <option value="{{ $type }}" {{ request('case_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('bk-cases.recap') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis</th>
                            <th>Judul</th>
                            <th>Guru BK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr>
                                <td>{{ $case->case_date->format('d M Y') }}</td>
                                <td>{{ $case->student?->name ?? '-' }}</td>
                                <td>{{ $case->student?->schoolClass?->name ?? '-' }}</td>
                                <td>{{ ucfirst($case->case_type) }}</td>
                                <td>{{ $case->title }}</td>
                                <td>{{ $case->teacher?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data rekap BK.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
