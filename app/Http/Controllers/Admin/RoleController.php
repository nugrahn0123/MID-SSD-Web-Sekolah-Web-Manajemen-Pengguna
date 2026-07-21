<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    use LogsActivity;
    public function index(): View
    {
        return view('admin.roles.index', [
            'roles' => Role::withCount('users')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role = Role::create($data);

        $this->logActivity('create_role', "Tambah role: {$role->name}");

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name,'.$role->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update($data);

        $this->logActivity('update_role', "Perbarui role: {$role->name}");

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->isSystemRole()) {
            return back()->with('error', 'Role sistem tidak dapat dihapus.');
        }

        $name = $role->name;
        $role->delete();

        $this->logActivity('delete_role', "Hapus role: {$name}");

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
