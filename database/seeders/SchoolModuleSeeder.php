<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\BkCase;
use App\Models\SchoolClass;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use App\Models\User;
use Illuminate\Database\Seeder;

class SchoolModuleSeeder extends Seeder
{
    public function run(): void
    {
        $teacherUsers = User::whereHas('role', fn ($query) => $query->whereIn('name', ['guru', 'guru_bk', 'wali_kelas']))
            ->orderBy('name')
            ->get();

        foreach ($teacherUsers as $index => $user) {
            Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_number' => 'GR' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '0812-0000-00' . ($index + 1),
                ]
            );
        }

        foreach ([
            ['code' => 'MTK', 'name' => 'Matematika'],
            ['code' => 'BIN', 'name' => 'Bahasa Indonesia'],
            ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'],
            ['code' => 'BK', 'name' => 'Bimbingan Konseling'],
        ] as $subject) {
            Subject::updateOrCreate(['code' => $subject['code']], $subject);
        }

        $year = AcademicYear::updateOrCreate(['name' => '2026/2027'], ['is_active' => true]);
        $semester = Semester::updateOrCreate(
            ['academic_year_id' => $year->id, 'name' => 'Ganjil'],
            ['is_active' => true]
        );

        $homeroomTeacher = Teacher::whereHas('user.role', fn ($query) => $query->where('name', 'wali_kelas'))->first();
        $classA = SchoolClass::updateOrCreate(
            ['name' => 'X IPA 1'],
            ['grade_level' => 'X', 'homeroom_teacher_id' => $homeroomTeacher?->id]
        );
        $classB = SchoolClass::updateOrCreate(
            ['name' => 'X IPA 2'],
            ['grade_level' => 'X', 'homeroom_teacher_id' => $homeroomTeacher?->id]
        );

        $studentUsers = User::whereHas('role', fn ($query) => $query->where('name', 'siswa'))->orderBy('name')->get();
        foreach ($studentUsers as $index => $user) {
            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'class_id' => $index % 2 === 0 ? $classA->id : $classB->id,
                    'nis' => 'SIS' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'name' => $user->name,
                    'gender' => $index % 2 === 0 ? 'L' : 'P',
                    'birth_date' => now()->subYears(16)->subDays($index + 10)->toDateString(),
                    'parent_name' => $index % 2 === 0 ? 'Bapak Pratama' : 'Ibu Fitri',
                    'parent_phone' => '0813-1000-00' . ($index + 1),
                    'status' => 'aktif',
                ]
            );
        }

        $guruTeacher = Teacher::whereHas('user.role', fn ($query) => $query->where('name', 'guru'))->orderBy('name')->first();
        $subject = Subject::where('code', 'MTK')->first();

        if ($guruTeacher && $subject) {
            TeachingJournal::updateOrCreate(
                [
                    'teacher_id' => $guruTeacher->id,
                    'class_id' => $classA->id,
                    'subject_id' => $subject->id,
                    'teaching_date' => now()->toDateString(),
                ],
                [
                    'semester_id' => $semester->id,
                    'material' => 'Persamaan Linear',
                    'learning_method' => 'Diskusi dan latihan soal',
                    'notes' => 'Sebagian siswa masih perlu penguatan konsep dasar.',
                ]
            );
        }

        $bkTeacher = Teacher::whereHas('user.role', fn ($query) => $query->where('name', 'guru_bk'))->first();
        $student = Student::orderBy('name')->first();

        if ($bkTeacher && $student) {
            BkCase::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'teacher_id' => $bkTeacher->id,
                    'case_type' => 'konseling',
                    'case_date' => now()->toDateString(),
                ],
                [
                    'title' => 'Pendampingan adaptasi belajar',
                    'description' => 'Siswa membutuhkan pendampingan awal untuk penyesuaian ritme belajar di semester baru.',
                    'follow_up_notes' => 'Jadwalkan evaluasi lanjutan pekan depan bersama wali kelas.',
                ]
            );
        }
    }
}