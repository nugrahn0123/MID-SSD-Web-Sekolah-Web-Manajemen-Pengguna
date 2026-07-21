@extends('layouts.app')

@section('title', 'Rekap Jurnal')
@section('page-title', 'Rekap Jurnal Mengajar')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2"></i>Rekap Jurnal Mengajar</h4>
        <a href="{{ route('journals.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('journals.recap') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Guru</label>
                    <select name="teacher_id" class="form-select form-select-sm">
                        <option value="">Semua Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
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
                    <label class="form-label small fw-semibold">Mapel</label>
                    <select name="subject_id" class="form-select form-select-sm">
                        <option value="">Semua Mapel</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('journals.recap') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Materi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journals as $journal)
                            <tr>
                                <td>{{ $journal->teaching_date->format('d M Y') }}</td>
                                <td>{{ $journal->teacher?->name ?? '-' }}</td>
                                <td>{{ $journal->schoolClass?->name ?? '-' }}</td>
                                <td>{{ $journal->subject?->name ?? '-' }}</td>
                                <td>{{ $journal->material }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data rekap jurnal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
