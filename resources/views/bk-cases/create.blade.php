@extends('layouts.app')

@section('title', 'Tambah Catatan BK')
@section('page-title', 'Tambah Catatan BK')

@section('content')
<div class="py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('bk-cases.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="fw-bold mb-0">Tambah Catatan BK</h4>
    </div>

    <div class="card stat-card" style="max-width:760px">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('bk-cases.store') }}">
                @csrf
                @if(auth()->user()->hasRole('admin'))
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Guru BK</label>
                        <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                            <option value="">-- Pilih Guru BK --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Siswa</label>
                        <select name="student_id" class="form-select @error('student_id') is-invalid @enderror">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }} - {{ $student->schoolClass?->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Kasus</label>
                        <select name="case_type" class="form-select @error('case_type') is-invalid @enderror">
                            @foreach(['konseling', 'pelanggaran', 'prestasi'] as $type)
                                <option value="{{ $type }}" {{ old('case_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('case_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="case_date" class="form-control @error('case_date') is-invalid @enderror" value="{{ old('case_date', now()->toDateString()) }}">
                        @error('case_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Tindak Lanjut</label>
                        <textarea name="follow_up_notes" rows="3" class="form-control @error('follow_up_notes') is-invalid @enderror">{{ old('follow_up_notes') }}</textarea>
                        @error('follow_up_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-primary">Simpan Catatan</button>
            </form>
        </div>
    </div>
</div>
@endsection