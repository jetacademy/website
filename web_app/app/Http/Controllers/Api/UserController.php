<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $users->transform(function ($user) {
            $user->role_names = $user->roles->pluck('name');
            return $user;
        });

        $roles = Role::pluck('name');

        return response()->json([
            'users' => $users,
            'available_roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'nullable|array',
            'roles.*' => ['nullable', 'string', Rule::exists('roles', 'name')],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles') && !empty($request->roles)) {
            // Only allow assigning roles that exist in the system
            $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();
            if (!empty($validRoles)) {
                $user->assignRole($validRoles);
            }
        } else {
            $user->assignRole('Operator');
        }

        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
            'user' => $user->load('roles')
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'nullable|array',
            'roles.*' => ['nullable', 'string', Rule::exists('roles', 'name')],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->has('roles')) {
            // Only allow assigning roles that exist in the system
            $validRoles = Role::whereIn('name', $request->roles ?? [])->pluck('name')->toArray();
            $user->syncRoles($validRoles);
        }

        return response()->json([
            'message' => 'Pengguna berhasil diperbarui.',
            'user' => $user->load('roles')
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting oneself
        if (auth()->id() == $user->id) {
            return response()->json(['message' => 'Tidak bisa menghapus akun Anda sendiri.'], 403);
        }

        // Prevent deleting the last Super Admin
        if ($user->hasRole('Super Admin')) {
            $superAdminCount = User::role('Super Admin')->count();
            if ($superAdminCount <= 1) {
                return response()->json(['message' => 'Tidak bisa menghapus Super Admin terakhir.'], 403);
            }
        }

        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus.']);
    }
}
