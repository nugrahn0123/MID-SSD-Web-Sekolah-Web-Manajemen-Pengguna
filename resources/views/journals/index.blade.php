@extends('layouts.app')

@section('title', 'Jurnal Mengajar')
@section('page-title', 'Jurnal Mengajar')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-book me-2"></i>Jurnal Mengajar</h4>
        <a href="{{ route('journals.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Input Jurnal</a>
    </div>

    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('journals.index') }}" class="row g-3 align-items-end">
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
                    <label class="form-label small fw-semibold">Mata Pelajaran</label>
                    <select name="subject_id" class="form-select form-select-sm">
                        <option value="">Semua Mapel</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-fill">Filter</button>
                    <a href="{{ route('journals.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                            <th>Metode</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journals as $journal)
                            <tr>
                                <td>{{ $journal->teaching_date->format('d M Y') }}</td>
                                <td>{{ $journal->teacher->name }}</td>
                                <td>{{ $journal->schoolClass->name }}</td>
                                <td>{{ $journal->subject->name }}</td>
                                <td>{{ $journal->material }}</td>
                                <td>{{ $journal->learning_method }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('journals.edit', $journal) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form method="POST" action="{{ route('journals.destroy', $journal) }}" onsubmit="return confirm('Hapus jurnal ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada jurnal mengajar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($journals->hasPages())
            <div class="card-footer bg-white">{{ $journals->links() }}</div>
        @endif
    </div>
</div>
@endsection