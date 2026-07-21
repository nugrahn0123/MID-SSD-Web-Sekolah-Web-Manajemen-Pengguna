<?php

namespace App\Http\Controllers;

use App\Models\BkCase;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BkCaseController extends Controller
{
    use LogsActivity;
    public function index(Request $request): View
    {
        $cases = BkCase::with(['student.schoolClass', 'teacher'])
            ->when($request->student_id, fn ($query, $studentId) => $query->where('student_id', $studentId))
            ->when($request->class_id, fn ($query, $classId) => $query->whereHas('student', fn ($studentQuery) => $studentQuery->where('class_id', $classId)))
            ->when($request->case_type, fn ($query, $type) => $query->where('case_type', $type))
            ->latest('case_date')
            ->paginate(10)
            ->withQueryString();

        return view('bk-cases.index', [
            'cases' => $cases,
            'students' => Student::with('schoolClass')->orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('bk-cases.create', [
            'teachers' => Teacher::orderBy('name')->get(),
            'students' => Student::with('schoolClass')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'student_id' => ['required', 'exists:students,id'],
            'case_type' => ['required', 'in:konseling,pelanggaran,prestasi'],
            'case_date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'follow_up_notes' => ['nullable', 'string'],
        ]);

        $data['teacher_id'] = $data['teacher_id'] ?? optional(auth()->user()->teacher)->id ?? Teacher::query()->value('id');

        $case = BkCase::create($data);

        $this->logActivity('create_bk_case', "Tambah kasus BK [{$case->case_type}]: {$case->title}");

        return redirect()->route('bk-cases.index')->with('success', 'Catatan BK berhasil disimpan.');
    }

    public function edit(BkCase $bkCase): View
    {
        return view('bk-cases.edit', [
            'case' => $bkCase->load(['student.schoolClass', 'teacher']),
            'teachers' => Teacher::orderBy('name')->get(),
            'students' => Student::with('schoolClass')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, BkCase $bkCase): RedirectResponse
    {
        $data = $request->validate([
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'student_id' => ['required', 'exists:students,id'],
            'case_type' => ['required', 'in:konseling,pelanggaran,prestasi'],
            'case_date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'follow_up_notes' => ['nullable', 'string'],
        ]);

        $data['teacher_id'] = $data['teacher_id'] ?? $bkCase->teacher_id;
        $bkCase->update($data);

        $this->logActivity('update_bk_case', "Perbarui kasus BK [{$bkCase->case_type}]: {$bkCase->title}");

        return redirect()->route('bk-cases.index')->with('success', 'Catatan BK berhasil diperbarui.');
    }

    public function destroy(BkCase $bkCase): RedirectResponse
    {
        $title = $bkCase->title;
        $type  = $bkCase->case_type;
        $bkCase->delete();

        $this->logActivity('delete_bk_case', "Hapus kasus BK [{$type}]: {$title}");

        return redirect()->route('bk-cases.index')->with('success', 'Catatan BK berhasil dihapus.');
    }

    public function recap(Request $request): View
    {
        $cases = BkCase::with(['student.schoolClass', 'teacher'])
            ->when($request->student_id, fn ($query, $studentId) => $query->where('student_id', $studentId))
            ->when($request->class_id, fn ($query, $classId) => $query->whereHas('student', fn ($studentQuery) => $studentQuery->where('class_id', $classId)))
            ->when($request->case_type, fn ($query, $type) => $query->where('case_type', $type))
            ->latest('case_date')
            ->get();

        return view('bk-cases.recap', [
            'cases' => $cases,
            'students' => Student::with('schoolClass')->orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('name')->get(),
        ]);
    }
}
