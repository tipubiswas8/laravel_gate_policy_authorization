@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Role Management</h2>
            </div>
            <div class="pull-right">
                @if (Gate::allows('role-create'))
                    <a class="btn btn-success btn-sm mb-2" href="{{ route('role.create') }}"><i class="fa fa-plus"></i> Create
                        New
                        Role</a>
                @endif
            </div>
        </div>
    </div>

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession

    <table class="table table-bordered">
        @if (Gate::allows('role-list'))
            <tr>
                <th width="100px">No</th>
                <th>Role Name</th>
                <th>Permissions Name</th>
                <th>Assigned User Name</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <ul>
                            @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @foreach ($role->users as $user)
                            <div style="display: flex;">
                                <p>{{ $user->name }} <small>({{ $user->email }})</small></p>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if (Gate::allows('role-show'))
                            <a class="btn btn-info btn-sm" href="{{ route('role.show', $role->id) }}"><i
                                    class="fa-solid fa-list"></i> Show</a>
                        @endif
                        @if (Gate::allows('role-edit'))
                            <a class="btn btn-primary btn-sm" href="{{ route('role.edit', $role->id) }}"><i
                                    class="fa-solid fa-pen-to-square"></i> Edit</a>
                        @endif
                        @if (Gate::allows('role-delete'))
                            <form method="POST" action="{{ route('role.destroy', $role->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    {!! $roles->links('pagination::bootstrap-5') !!}

@endsection
