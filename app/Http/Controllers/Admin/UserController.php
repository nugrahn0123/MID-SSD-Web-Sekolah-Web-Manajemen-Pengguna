<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    use LogsActivity;
    public function index(Request $request): View
    {
        $users = User::with('role')
            ->when($request->search, fn ($query, $search) => $query->where(function ($subQuery) use ($search): void {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when($request->role, fn ($query, $role) => $query->whereHas('role', fn ($roleQuery) => $roleQuery->where('name', $role)))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $this->logActivity('create_user', "Tambah pengguna: {$user->name} ({$user->email})");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user->load('role'),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        $this->logActivity('update_user', "Perbarui pengguna: {$user->name} ({$user->email})");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Status akun sendiri tidak dapat diubah dari halaman ini.');
        }

        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $newStatus]);

        $this->logActivity('toggle_user_status', "Status pengguna {$user->name} diubah menjadi {$newStatus}");

        return back()->with('success', 'Status pengguna diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Akun sendiri tidak dapat dihapus.');
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        $this->logActivity('delete_user', "Hapus pengguna: {$name} ({$email})");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
