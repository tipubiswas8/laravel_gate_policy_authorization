@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Home</h2>
            </div>
        </div>
    </div>
    <div>
        <hr>
        <h4>User: {{ $user->name }}</h4>

        <h5>Roles</h5>
        @if ($roles->isNotEmpty())
            @foreach ($roles as $role)
                <label style="background-color: gray" class="badge badge-info">{{ $role }}</label>
            @endforeach
        @else
            <p>No have role</p>
        @endif

        <h5>Roles Permissions</h5>
        @if ($rolesPermissions->isNotEmpty())
            @foreach ($rolesPermissions as $permission)
                <label style="background-color: gray" class="badge badge-info">{{ $permission }}</label>
            @endforeach
        @else
            <p>No have role permission</p>
        @endif

        <h5>Direct Permissions</h5>
        @if ($directPermissions->isNotEmpty())
            @foreach ($directPermissions as $permission)
                <label style="background-color: gray" class="badge badge-info">{{ $permission }}</label>
            @endforeach
        @else
            <p>No have direct permission</p>
        @endif

        <h5>All Permissions</h5>
        @if ($allPermissions->isNotEmpty())
            @foreach ($allPermissions as $permission)
                <label style="background-color: gray" class="badge badge-info">{{ $permission }}</label>
            @endforeach
        @else
            <p>No have permission</p>
        @endif
    </div>
@endsection
