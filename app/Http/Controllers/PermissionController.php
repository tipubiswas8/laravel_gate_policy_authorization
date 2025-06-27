<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function index()
    {
        if (!Gate::allows('permission-list')) {
            abort(403);
        }

        return view('permissions.index', [
            'permissions' => Permission::with('roles')->paginate(5),
            'roles' => Role::all()
        ]);
    }

    public function create()
    {
        if (!Gate::allows('permission-create')) {
            abort(403);
        }

        $roles = Role::all();
        return view('permissions.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('permission-create')) {
            abort(403);
        }

        $permission = Permission::create(['name' => $request->name]);
        $permission->roles()->sync($request->roles);
        // $permission->permissions()->sync($request->permissions);
        return back()->with('success', 'Permission created successfully!');
    }

    public function show(Permission $permission)
    {
        if (!Gate::allows('permission-show')) {
            abort(403);
        }

        return view('permissions.show', compact('permission'));
    }


    public function edit(Permission $permission)
    {
        if (!Gate::allows('permission-edit')) {
            abort(403);
        }

        $roles = Role::all();
        return view('permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        if (!Gate::allows('permission-edit')) {
            abort(403);
        }

        $permission->update($request->only('title', 'body'));
        $permission->roles()->sync($request->roles);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully!');
    }

    public function destroy(Permission $permission)
    {
        if (!Gate::allows('permission-delete')) {
            abort(403);
        }

        $permission->delete();
        return back()->with('success', 'Permission deleted successfully!');
    }
}
