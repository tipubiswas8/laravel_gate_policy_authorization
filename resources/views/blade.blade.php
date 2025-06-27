@can('admin-only')
    <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
@endcan

@can('access-admin-panel')
    <a href="/admin" class="btn btn-warning">Admin Panel</a>
@endcan

@if (Gate::allows('edit-settings'))
    <p>You can edit settings!</p>
@endif









