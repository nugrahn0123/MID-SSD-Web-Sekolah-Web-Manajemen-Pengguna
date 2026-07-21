@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')

@section('content')
<div class="py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.classes.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="fw-bold mb-0">Tambah Kelas</h4>
    </div>

    <div class="card stat-card" style="max-width:600px">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kelas</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: X IPA 1" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tingkat</label>
                    <input type="text" name="grade_level" class="form-control @error('grade_level') is-invalid @enderror" value="{{ old('grade_level') }}" placeholder="Contoh: X" required>
                    @error('grade_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Wali Kelas</label>
                    <select name="homeroom_teacher_id" class="form-select @error('homeroom_teacher_id') is-invalid @enderror">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('homeroom_teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection