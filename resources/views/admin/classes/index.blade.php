@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Manajemen Kelas')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-diagram-3 me-2"></i>Data Kelas</h4>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Tambah Kelas</a>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $class->name }}</td>
                                <td>{{ $class->grade_level }}</td>
                                <td>{{ $class->homeroomTeacher?->name ?? '-' }}</td>
                                <td><span class="badge bg-primary rounded-pill">{{ $class->students_count }}</span></td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('Hapus kelas {{ addslashes($class->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data kelas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection