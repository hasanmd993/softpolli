<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAdminController extends Controller
{
    /**
     * Display users, roles, and permissions management.
     */
    public function index(Request $request): Response
    {
        $users = User::with('roles')
            ->orderBy('id')
            ->get()
            ->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'roles' => $user->roles->pluck('name'),
                'created_at' => $user->created_at?->format('Y-m-d H:i'),
            ]);

        $roles = Role::with('permissions')
            ->orderBy('id')
            ->get()
            ->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
                'users_count' => $role->users()->count(),
            ]);

        $permissions = Permission::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
            'currentUserId' => $request->user()?->id,
        ]);
    }

    /**
     * Store a newly created user with role assignment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);

        $isAdmin = in_array($validated['role'], ['Super Admin', 'Admin']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $isAdmin,
        ]);

        $user->assignRole($validated['role']);

        activity('admin')
            ->causedBy($request->user())
            ->performedOn($user)
            ->log("Created new user '{$user->email}' with role '{$validated['role']}'");

        return redirect()->back()->with('success', "User '{$user->name}' created successfully with role '{$validated['role']}'.");
    }

    /**
     * Update an existing user and their role assignment.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', Password::min(8)],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);

        $isAdmin = in_array($validated['role'], ['Super Admin', 'Admin']);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $isAdmin;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        activity('admin')
            ->causedBy($request->user())
            ->performedOn($user)
            ->log("Updated user account '{$user->email}' and role '{$validated['role']}'");

        return redirect()->back()->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Delete a user account (cannot delete own account).
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $userName = $user->name;
        $userEmail = $user->email;

        $user->syncRoles([]);
        $user->delete();

        activity('admin')
            ->causedBy($request->user())
            ->log("Deleted user account '{$userEmail}' ({$userName})");

        return redirect()->back()->with('success', "User '{$userName}' deleted successfully.");
    }

    /**
     * Export staff users list to Excel.
     */
    public function export()
    {
        return (new FastExcel(User::with('roles')->orderBy('id')->get()))->download('softpolli-staff-' . date('Y-m-d') . '.xlsx', function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Roles' => $user->roles->pluck('name')->implode(', ') ?: 'Standard Staff',
                'Admin Status' => $user->is_admin ? 'Super Admin' : 'Staff',
                'Joined Date' => $user->created_at?->format('Y-m-d H:i') ?? '',
            ];
        });
    }
}

