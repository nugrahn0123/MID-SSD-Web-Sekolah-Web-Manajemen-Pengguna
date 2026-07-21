@extends('layouts.app')

@section('title', 'Modul BK')
@section('page-title', 'Data BK dan Konseling')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-clipboard2-heart me-2"></i>Riwayat BK</h4>
        <a href="{{ route('bk-cases.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Tambah Catatan BK</a>
    </div>

    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('bk-cases.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Siswa</label>
                    <select name="student_id" class="form-select form-select-sm">
                        <option value="">Semua Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Kelas</label>
                    <select name="class_id" class="form-select form-select-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Jenis</label>
                    <select name="case_type" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['konseling', 'pelanggaran', 'prestasi'] as $type)
                            <option value="{{ $type }}" {{ request('case_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-fill">Filter</button>
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
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr>
                                <td>{{ $case->case_date->format('d M Y') }}</td>
                                <td>{{ $case->student->name }}</td>
                                <td>{{ $case->student->schoolClass?->name ?? '-' }}</td>
                                <td><span class="badge bg-warning text-dark text-uppercase">{{ $case->case_type }}</span></td>
                                <td>{{ $case->title }}</td>
                                <td>{{ $case->teacher->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('bk-cases.edit', $case) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form method="POST" action="{{ route('bk-cases.destroy', $case) }}" onsubmit="return confirm('Hapus catatan BK ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada catatan BK.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($cases->hasPages())
            <div class="card-footer bg-white">{{ $cases->links() }}</div>
        @endif
    </div>
</div>
@endsection