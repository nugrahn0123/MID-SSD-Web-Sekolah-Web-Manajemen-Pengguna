<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Modul Manajemen Pengguna
|--------------------------------------------------------------------------
|
| Endpoint ini digunakan oleh modul lain (Jurnal Mengajar, BK,
| Data Kesiswaan, Akademik) untuk:
|   1. Mendapatkan token autentikasi (login via API)
|   2. Memverifikasi token + role user yang sedang login
|   3. Mengambil data user/role untuk keperluan relasi antar modul
|
| Semua request ke endpoint protected WAJIB menyertakan header:
|   Authorization: Bearer {sanctum_token}
*/

// ─── Public Auth (tidak butuh token) ─────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthApiController::class, 'login'])
        ->name('api.auth.login');
});

// ─── Protected (butuh Sanctum token) ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthApiController::class, 'logout'])
        ->name('api.auth.logout');

    /**
     * Endpoint utama integrasi antar modul:
     * Modul lain panggil ini untuk verifikasi siapa yang sedang login + rolenya.
     * GET /api/auth/verify
     */
    Route::get('/auth/verify', [AuthApiController::class, 'verify'])
        ->name('api.auth.verify');

    // User data
    Route::get('/users', [UserApiController::class, 'index'])
        ->name('api.users.index');

    Route::get('/users/{id}/role', [UserApiController::class, 'getRole'])
        ->name('api.users.role');
});
