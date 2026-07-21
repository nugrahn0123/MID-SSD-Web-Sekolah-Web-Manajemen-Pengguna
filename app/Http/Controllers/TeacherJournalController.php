<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherJournalController extends Controller
{
    use LogsActivity;
    public function index(Request $request): View
    {
        $journals = TeachingJournal::with(['teacher', 'schoolClass', 'subject'])
            ->when($request->class_id, fn ($query, $classId) => $query->where('class_id', $classId))
            ->when($request->subject_id, fn ($query, $subjectId) => $query->where('subject_id', $subjectId))
            ->latest('teaching_date')
            ->paginate(10)
            ->withQueryString();

        return view('journals.index', [
            'journals' => $journals,
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('journals.create', [
            'teachers' => Teacher::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'semesters' => \App\Models\Semester::with('academicYear')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'semester_id' => ['nullable', 'exists:semesters,id'],
            'teaching_date' => ['required', 'date'],
            'material' => ['required', 'string', 'max:255'],
            'learning_method' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['teacher_id'] = $data['teacher_id'] ?? optional(auth()->user()->teacher)->id ?? Teacher::query()->value('id');

        $journal = TeachingJournal::create($data);

        $this->logActivity('create_journal', "Input jurnal: {$journal->material} ({$journal->teaching_date})");

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function edit(TeachingJournal $journal): View
    {
        return view('journals.edit', [
            'journal' => $journal->load(['teacher', 'schoolClass', 'subject', 'semester.academicYear']),
            'teachers' => Teacher::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'semesters' => \App\Models\Semester::with('academicYear')->orderByDesc('id')->get(),
        ]);
    }

    public function update(Request $request, TeachingJournal $journal): RedirectResponse
    {
        $data = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'semester_id' => ['nullable', 'exists:semesters,id'],
            'teaching_date' => ['required', 'date'],
            'material' => ['required', 'string', 'max:255'],
            'learning_method' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['teacher_id'] = $data['teacher_id'] ?? $journal->teacher_id;
        $journal->update($data);

        $this->logActivity('update_journal', "Perbarui jurnal: {$journal->material} ({$journal->teaching_date})");

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(TeachingJournal $journal): RedirectResponse
    {
        $material = $journal->material;
        $date     = $journal->teaching_date;
        $journal->delete();

        $this->logActivity('delete_journal', "Hapus jurnal: {$material} ({$date})");

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    public function recap(Request $request): View
    {
        $journals = TeachingJournal::with(['teacher', 'schoolClass', 'subject'])
            ->when($request->teacher_id, fn ($query, $teacherId) => $query->where('teacher_id', $teacherId))
            ->when($request->class_id, fn ($query, $classId) => $query->where('class_id', $classId))
            ->when($request->subject_id, fn ($query, $subjectId) => $query->where('subject_id', $subjectId))
            ->latest('teaching_date')
            ->get();

        return view('journals.recap', [
            'journals' => $journals,
            'teachers' => Teacher::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }
}
