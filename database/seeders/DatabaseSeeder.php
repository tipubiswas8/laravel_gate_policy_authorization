<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Define permission name arrays
        $permissionsForAdmin = [
            'role-list', 'role-show', 'role-create', 'role-edit', 'role-delete',
            'permission-list', 'permission-show', 'permission-create', 'permission-edit', 'permission-delete',
            'user-list', 'user-show', 'user-create', 'user-edit', 'user-delete',
            'product-list', 'product-show', 'product-create', 'product-edit', 'product-delete',
            'post-list', 'post-show', 'post-create', 'post-edit', 'post-delete'
        ];

        $permissionsForEditor = [
            'role-list', 'role-show', 'role-edit',
            'permission-list', 'permission-show', 'permission-edit',
            'user-list', 'user-show', 'user-edit',
            'product-list', 'product-show', 'product-edit',
            'post-list', 'post-show', 'post-edit'
        ];

        $permissionsForViewer = [
            'role-list', 'role-show',
            'permission-list', 'permission-show',
            'user-list', 'user-show',
            'product-list', 'product-show',
            'post-list', 'post-show'
        ];

        // Create permissions (only once)
        $allPermissionNames = array_unique(array_merge(
            $permissionsForAdmin,
            $permissionsForEditor,
            $permissionsForViewer
        ));

        $allPermissions = [];
        foreach ($allPermissionNames as $name) {
            $allPermissions[$name] = Permission::create(['name' => $name]);
        }

        // Create users
        $userAdmin = User::create([
            'name' => 'U-Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $userEditor = User::create([
            'name' => 'U-Editor',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'editor',
        ]);

        $userViewer = User::create([
            'name' => 'U-Viewer',
            'email' => 'viewer@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'viewer',
        ]);

        // Create roles
        $roleAdmin = Role::create(['name' => 'R-Admin']);
        $roleEditor = Role::create(['name' => 'R-Editor']);
        $roleViewer = Role::create(['name' => 'R-Viewer']);

        // Assign users to roles
        $userAdmin->roles()->sync([$roleAdmin->id]);
        $userEditor->roles()->sync([$roleEditor->id]);
        $userViewer->roles()->sync([$roleViewer->id]);

        // Assign permissions to roles
        $roleAdmin->permissions()->sync(collect($permissionsForAdmin)->map(fn($name) => $allPermissions[$name]->id));
        $roleEditor->permissions()->sync(collect($permissionsForEditor)->map(fn($name) => $allPermissions[$name]->id));
        $roleViewer->permissions()->sync(collect($permissionsForViewer)->map(fn($name) => $allPermissions[$name]->id));
    }
}
