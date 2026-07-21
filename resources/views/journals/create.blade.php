@extends('layouts.app')

@section('title', 'Input Jurnal')
@section('page-title', 'Input Jurnal Mengajar')

@section('content')
<div class="py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('journals.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="fw-bold mb-0">Input Jurnal Mengajar</h4>
    </div>

    <div class="card stat-card" style="max-width:760px">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('journals.store') }}">
                @csrf
                @if(auth()->user()->hasRole('admin'))
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Guru</label>
                        <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mata Pelajaran</label>
                        <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Semester</label>
                        <select name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                            <option value="">-- Pilih Semester --</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>{{ $semester->academicYear->name }} - {{ $semester->name }}</option>
                            @endforeach
                        </select>
                        @error('semester_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Mengajar</label>
                        <input type="date" name="teaching_date" class="form-control @error('teaching_date') is-invalid @enderror" value="{{ old('teaching_date', now()->toDateString()) }}">
                        @error('teaching_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Materi Pembelajaran</label>
                        <input type="text" name="material" class="form-control @error('material') is-invalid @enderror" value="{{ old('material') }}">
                        @error('material')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Metode Pembelajaran</label>
                        <input type="text" name="learning_method" class="form-control @error('learning_method') is-invalid @enderror" value="{{ old('learning_method') }}">
                        @error('learning_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-primary">Simpan Jurnal</button>
            </form>
        </div>
    </div>
</div>
@endsection