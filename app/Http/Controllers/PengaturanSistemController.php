<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Activity;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanSistemController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'users');

        $users = User::with('role')->latest()->get();
        $roles = Role::with('permissionGroup')->get();
        $permissions = Permission::all();
        $permissionGroups = PermissionGroup::with('permissions')->get();
        $activities = Activity::latest()->take(50)->get();

        return view('pengaturan-sistem.index', compact(
            'tab', 'users', 'roles', 'permissions', 'permissionGroups', 'activities'
        ));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
        ]);

        $role = Role::where('name', $data['role'])->first();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password123'),
            'role_id' => $role?->id,
            'status' => true,
        ]);

        $this->logActivity('Manajemen User', 'CREATE', "Created new user: {$data['email']} with role {$data['role']}");

        return redirect()->route('pengaturan-sistem.index', ['tab' => 'users'])->with('success', 'User berhasil dibuat.');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);

        $role = Role::where('name', $data['role'])->first();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $role?->id,
        ]);

        $this->logActivity('Manajemen User', 'UPDATE', "Updated user ID: {$user->id} ({$data['email']})");

        return redirect()->route('pengaturan-sistem.index', ['tab' => 'users'])->with('success', 'User berhasil diperbarui.');
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['status' => !$user->status]);

        $action = $user->status ? 'Activated' : 'Deactivated';
        $this->logActivity('Manajemen User', 'UPDATE', "{$action} user ID: {$user->id}");

        return redirect()->route('pengaturan-sistem.index', ['tab' => 'users'])->with('success', "User berhasil {$action}.");
    }

    public function destroyUser(User $user)
    {
        $email = $user->email;
        $user->delete();

        $this->logActivity('Manajemen User', 'DELETE', "Deleted user: {$email}");

        return redirect()->route('pengaturan-sistem.index', ['tab' => 'users'])->with('success', 'User berhasil dihapus.');
    }

    public function updatePermissionGroup(Request $request, PermissionGroup $group)
    {
        $data = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $group->permissions()->sync($data['permissions'] ?? []);

        $this->logActivity('Pengaturan Sistem', 'UPDATE', "Updated permissions for group ID: {$group->id}");

        return redirect()->route('pengaturan-sistem.index', ['tab' => 'permissions'])->with('success', 'Perizinan berhasil diperbarui.');
    }
}
