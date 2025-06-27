<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Roles
        $roles = $user->roles->pluck('name');

        // Direct permissions
        $directPermissions = $user->permissions->pluck('name');

        // Role permissions (merged from all roles)
        $rolesPermissions = collect();
        foreach ($user->roles as $role) {
            $rolesPermissions = $rolesPermissions->merge($role->permissions->pluck('name'));
        }
        $rolesPermissions = $rolesPermissions->unique()->values();

        // All permissions = direct + from roles
        $allPermissions = $directPermissions->merge($rolesPermissions)->unique()->values();

        return view('home', [
            'user' => $user,
            'roles' => $roles,
            'rolesPermissions' => $rolesPermissions,
            'directPermissions' => $directPermissions,
            'allPermissions' => $allPermissions
        ]);
    }
}
