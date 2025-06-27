@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Permission Management</h2>
            </div>
            <div class="pull-right">
                @if (Gate::allows('permission-create'))
                    <a class="btn btn-success btn-sm mb-2" href="{{ route('permissions.create') }}"><i class="fa fa-plus"></i>
                        Create New Permission</a>
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
        @if (Gate::allows('permission-list'))
            <tr>
                <th width="100px">No</th>
                <th>Permission Name</th>
                <th>Role Name</th>
                <th>Assigned Direct User</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($permissions as $key => $permission)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        @foreach ($permission->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($permission->users as $user)
                            <div style="display: flex;">
                                <p>{{ $user->name }} <small>({{ $user->email }})</small></p>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if (Gate::allows('permission-show'))
                            <a class="btn btn-info btn-sm" href="{{ route('permissions.show', $permission->id) }}"><i
                                    class="fa-solid fa-list"></i> Show</a>
                        @endif
                        @if (Gate::allows('permission-edit'))
                            <a class="btn btn-primary btn-sm" href="{{ route('permissions.edit', $permission->id) }}"><i
                                    class="fa-solid fa-pen-to-square"></i> Edit</a>
                        @endif
                        @if (Gate::allows('permission-delete'))
                            <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}"
                                style="display:inline">
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

    {!! $permissions->links('pagination::bootstrap-5') !!}
@endsection
