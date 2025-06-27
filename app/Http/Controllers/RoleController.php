<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        if (!Gate::allows('role-list')) {
            abort(403);
        }
        
        return view('roles.index', [
            'permissions' => Permission::all(),
            'roles' => Role::with('permissions')->paginate(5)
        ]);
    }

    public function create()
    {
        if (!Gate::allows('role-create')) {
            abort(403);
        }

        $permissions = Permission::all();
        return view('roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('role-create')) {
            abort(403);
        }

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return back()->with('success', 'Role created successfully!');
    }

    public function show(Role $role)
    {
        if (!Gate::allows('role-show')) {
            abort(403);
        }

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        if (!Gate::allows('role-edit')) {
            abort(403);
        }

        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if (!Gate::allows('role-edit')) {
            abort(403);
        }

        $role->update($request->only('title', 'body'));
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        if (!Gate::allows('role-delete')) {
            abort(403);
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully!');
    }
}
