<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    use LogsActivity;
    public function index(Request $request): View
    {
        $students = Student::with(['schoolClass', 'user'])
            ->when($request->class_id, fn ($query, $classId) => $query->where('class_id', $classId))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.students.index', [
            'students' => $students,
            'classes' => SchoolClass::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'readOnly' => false,
        ]);
    }

    public function create(): View
    {
        return view('admin.students.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users,id', 'unique:students,user_id'],
            'class_id' => ['nullable', 'exists:classes,id'],
            'nis' => ['required', 'string', 'max:30', 'unique:students,nis'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_date' => ['nullable', 'date'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['aktif', 'pindah', 'lulus', 'keluar'])],
        ]);

        $student = Student::create($data);

        $this->logActivity('create_student', "Tambah siswa: {$student->name} (NIS: {$student->nis})");

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        return view('admin.students.edit', [
            'student' => $student->load(['schoolClass', 'user']),
            'classes' => SchoolClass::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users,id', Rule::unique('students', 'user_id')->ignore($student->id)],
            'class_id' => ['nullable', 'exists:classes,id'],
            'nis' => ['required', 'string', 'max:30', Rule::unique('students', 'nis')->ignore($student->id)],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_date' => ['nullable', 'date'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['aktif', 'pindah', 'lulus', 'keluar'])],
        ]);

        $student->update($data);

        $this->logActivity('update_student', "Perbarui siswa: {$student->name} (NIS: {$student->nis})");

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->name;
        $nis  = $student->nis;
        $student->delete();

        $this->logActivity('delete_student', "Hapus siswa: {$name} (NIS: {$nis})");

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function export(): RedirectResponse
    {
        $this->logActivity('export_students', 'Export data siswa ke CSV');

        $filename = 'students-export-'.now()->format('Ymd-His').'.csv';
        $students = Student::with('schoolClass')->orderBy('name')->get();

        return response()->streamDownload(function () use ($students): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['nis', 'name', 'gender', 'class_name', 'status', 'birth_date', 'parent_name', 'parent_phone']);

            foreach ($students as $student) {
                fputcsv($output, [
                    $student->nis,
                    $student->name,
                    $student->gender,
                    $student->schoolClass?->name,
                    $student->status,
                    optional($student->birth_date)->format('Y-m-d'),
                    $student->parent_name,
                    $student->parent_phone,
                ]);
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function import(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $handle = fopen($data['file']->getRealPath(), 'r');
        if ($handle === false) {
            return back()->with('error', 'File CSV tidak dapat dibaca.');
        }

        $header = fgetcsv($handle);
        if (! $header) {
            fclose($handle);
            return back()->with('error', 'File CSV kosong.');
        }

        $header = array_map('trim', $header);
        $classMap = SchoolClass::pluck('id', 'name')->all();

        while (($row = fgetcsv($handle)) !== false) {
            $record = array_combine($header, array_pad($row, count($header), null));
            if (! is_array($record) || blank($record['nis'] ?? null) || blank($record['name'] ?? null)) {
                continue;
            }

            $classId = null;
            $className = trim((string) ($record['class_name'] ?? ''));
            if ($className !== '') {
                $classId = $classMap[$className] ?? null;
            }

            Student::updateOrCreate(
                ['nis' => $record['nis']],
                [
                    'name' => $record['name'],
                    'gender' => strtoupper(trim((string) ($record['gender'] ?? 'L'))),
                    'class_id' => $classId,
                    'status' => $record['status'] ?: 'aktif',
                    'birth_date' => $record['birth_date'] ?: null,
                    'parent_name' => $record['parent_name'] ?: null,
                    'parent_phone' => $record['parent_phone'] ?: null,
                ]
            );
        }

        fclose($handle);

        $this->logActivity('import_students', 'Import data siswa dari CSV');

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor.');
    }

    public function overview(Request $request): View
    {
        $students = Student::with(['schoolClass', 'user'])
            ->when($request->class_id, fn ($query, $classId) => $query->where('class_id', $classId))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.students.index', [
            'students' => $students,
            'classes' => SchoolClass::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'readOnly' => true,
        ]);
    }
}
