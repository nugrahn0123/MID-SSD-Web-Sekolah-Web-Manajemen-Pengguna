<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    use LogsActivity;
    public function index(): View
    {
        return view('admin.classes.index', [
            'classes' => SchoolClass::with('homeroomTeacher')->withCount('students')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.classes.create', [
            'teachers' => Teacher::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:classes,name'],
            'grade_level' => ['required', 'string', 'max:20'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $class = SchoolClass::create($data);

        $this->logActivity('create_class', "Tambah kelas: {$class->name}");

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class): View
    {
        return view('admin.classes.edit', [
            'class' => $class,
            'teachers' => Teacher::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, SchoolClass $class): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:classes,name,'.$class->id],
            'grade_level' => ['required', 'string', 'max:20'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($data);

        $this->logActivity('update_class', "Perbarui kelas: {$class->name}");

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class): RedirectResponse
    {
        $name = $class->name;
        $class->delete();

        $this->logActivity('delete_class', "Hapus kelas: {$name}");

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
