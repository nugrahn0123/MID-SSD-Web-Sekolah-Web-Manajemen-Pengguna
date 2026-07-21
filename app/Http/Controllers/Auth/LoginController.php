<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'aktif',
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => __('Email atau password salah.'),
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'Login berhasil',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->intended($this->dashboardRouteFor($user->role->name));
    }

    private function dashboardRouteFor(string $roleName): string
    {
        return match ($roleName) {
            'admin' => route('admin.dashboard'),
            'kepala_sekolah' => route('kepala_sekolah.dashboard'),
            'guru' => route('guru.dashboard'),
            'guru_bk' => route('guru_bk.dashboard'),
            'wali_kelas' => route('wali_kelas.dashboard'),
            'siswa' => route('siswa.dashboard'),
            'orang_tua' => route('orang_tua.dashboard'),
            default => route('dashboard'),
        };
    }
}
