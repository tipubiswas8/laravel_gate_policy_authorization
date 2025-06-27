<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-list')) {
            abort(403);
        }

        $users = User::with('roles', 'permissions')->latest()->paginate(5);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.index', [
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
            'i' => ($request->input('page', 1) - 1) * 5,
        ]);
    }

    /**
     * Show form to create a user.
     */
    public function create(): View
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-create')) {
            abort(403);
        }

        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.create', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Store a new user.
     */
    public function store(Request $request): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);

        // // Attach roles without removing or duplicating existing ones
        // if ($request->filled('roles')) {
        //     $user->roles()->syncWithoutDetaching($request->roles);
        // }

        // // Attach permissions without removing or duplicating existing ones
        // if ($request->filled('permissions')) {
        //     $user->permissions()->syncWithoutDetaching($request->permissions);
        // }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show($id): View
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-show')) {
            abort(403);
        }

        $user = User::with('roles', 'permissions')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show form to edit a user.
     */
    public function edit($id): View
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-edit')) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the user.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-edit')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::findOrFail($id);

        $updateData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        $user->update($updateData);
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);

        // // Attach roles without removing or duplicating existing ones
        // if ($request->filled('roles')) {
        //     $user->roles()->syncWithoutDetaching($request->roles);
        // }

        // // Attach permissions without removing or duplicating existing ones
        // if ($request->filled('permissions')) {
        //     $user->permissions()->syncWithoutDetaching($request->permissions);
        // }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Delete the user.
     */
    public function destroy($id): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser->hasPermission('user-delete')) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
