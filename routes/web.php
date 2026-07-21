<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BkCaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherJournalController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\MonitoringController;
use Illuminate\Support\Facades\Route;

// ─── Redirect root ────────────────────────────────────────────────────────────
Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : redirect()->route('login')
);

// ─── Guest-only routes (belum login) ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// ─── Authenticated routes ─────────────────────────────────────────────────────
Route::middleware(['auth', 'check.status'])->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Dashboard utama (semua role bisa akses, view menyesuaikan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Alias dashboard per-role (untuk redirect setelah login)
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/kepala-sekolah/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:kepala_sekolah')
        ->name('kepala_sekolah.dashboard');

    Route::get('/guru/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:guru')
        ->name('guru.dashboard');

    Route::get('/guru-bk/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:guru_bk')
        ->name('guru_bk.dashboard');

    Route::get('/wali-kelas/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:wali_kelas')
        ->name('wali_kelas.dashboard');

    Route::get('/siswa/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:siswa')
        ->name('siswa.dashboard');

    Route::get('/orang-tua/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:orang_tua')
        ->name('orang_tua.dashboard');

    Route::get('/students-overview', [StudentController::class, 'overview'])
        ->middleware('role:admin,kepala_sekolah,wali_kelas')
        ->name('students.overview');

    Route::get('/journals/recap', [TeacherJournalController::class, 'recap'])
        ->middleware('role:guru,wali_kelas,admin')
        ->name('journals.recap');

    Route::get('/bk-cases/recap', [BkCaseController::class, 'recap'])
        ->middleware('role:guru_bk,admin,kepala_sekolah')
        ->name('bk-cases.recap');

    // ─── Admin-only routes ────────────────────────────────────────────────────
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Manajemen Role
            Route::resource('roles', RoleController::class)->except(['show']);

            // Data Kesiswaan
            Route::resource('classes', ClassController::class)->except(['show']);
            Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
            Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
            Route::resource('students', StudentController::class)->except(['show']);

            // Manajemen Pengguna (CRUD)
            Route::resource('users', UserController::class)->except(['show']);
            Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
                ->name('users.toggle-status');

            // Audit Log
            Route::get('activity-logs', [ActivityLogController::class, 'index'])
                ->name('activity-logs.index');
            Route::get('activity-logs/export', [ActivityLogController::class, 'export'])
                ->name('activity-logs.export');

            // System Monitor
            Route::get('monitoring', [MonitoringController::class, 'index'])
                ->name('monitoring.index');
        });

    Route::middleware('role:guru,wali_kelas,admin')
        ->prefix('journals')
        ->name('journals.')
        ->group(function () {
            Route::get('/', [TeacherJournalController::class, 'index'])->name('index');
            Route::get('/create', [TeacherJournalController::class, 'create'])->name('create');
            Route::post('/', [TeacherJournalController::class, 'store'])->name('store');
            Route::get('/{journal}/edit', [TeacherJournalController::class, 'edit'])->name('edit');
            Route::put('/{journal}', [TeacherJournalController::class, 'update'])->name('update');
            Route::delete('/{journal}', [TeacherJournalController::class, 'destroy'])->name('destroy');
        });

    Route::middleware('role:guru_bk,admin')
        ->prefix('bk-cases')
        ->name('bk-cases.')
        ->group(function () {
            Route::get('/', [BkCaseController::class, 'index'])->name('index');
            Route::get('/create', [BkCaseController::class, 'create'])->name('create');
            Route::post('/', [BkCaseController::class, 'store'])->name('store');
            Route::get('/{bkCase}/edit', [BkCaseController::class, 'edit'])->name('edit');
            Route::put('/{bkCase}', [BkCaseController::class, 'update'])->name('update');
            Route::delete('/{bkCase}', [BkCaseController::class, 'destroy'])->name('destroy');
        });
});
