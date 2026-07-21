@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Kesiswaan')

@section('content')
@php($studentIndexRoute = request()->routeIs('students.overview') ? route('students.overview') : route('admin.students.index'))
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-mortarboard me-2"></i>Data Siswa</h4>
        @if(empty($readOnly))
            <div class="d-flex gap-2">
                <a href="{{ route('admin.students.export') }}" class="btn btn-outline-success"><i class="bi bi-download me-1"></i> Export CSV</a>
                <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i> Tambah Siswa</a>
            </div>
        @endif
    </div>

    <div class="card stat-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ $studentIndexRoute }}" class="row g-3 align-items-end mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Cari Nama / NIS</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
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
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['aktif', 'pindah', 'lulus', 'keluar'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-fill">Filter</button>
                    <a href="{{ $studentIndexRoute }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>

            @if(empty($readOnly))
                <form method="POST" action="{{ route('admin.students.import') }}" enctype="multipart/form-data" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Import CSV Siswa</label>
                        <input type="file" name="file" class="form-control form-control-sm @error('file') is-invalid @enderror" required>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary btn-sm w-100"><i class="bi bi-upload me-1"></i> Import</button>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Header CSV: nis, name, gender, class_name, status, birth_date, parent_name, parent_phone</small>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Orang Tua</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $students->firstItem() + $loop->index }}</td>
                                <td>{{ $student->nis }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $student->name }}</div>
                                    <small class="text-muted">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                </td>
                                <td>{{ $student->schoolClass?->name ?? '-' }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $student->status }}</span></td>
                                <td>{{ $student->parent_name ?: '-' }}</td>
                                <td class="text-center">
                                    @if(empty($readOnly))
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                            <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Hapus siswa {{ addslashes($student->name) }}?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted small">Lihat data</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
            <div class="card-footer bg-white">{{ $students->links() }}</div>
        @endif
    </div>
</div>
@endsection