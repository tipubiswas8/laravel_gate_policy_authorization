@extends('layouts.app')

@section('content')
    <h2>Posts</h2>

    @if (Gate::allows('post-create'))
        <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create Post</a>
    @endif

        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession

    @if (Gate::allows('post-list'))
        @foreach ($posts as $post)
            <div class="card mb-2">
                <div class="card-body">
                    <h5>{{ $post->title }}</h5>
                    <p>{{ $post->body }}</p>
                    <small>By: {{ $post->user?->name ?? 'Unknown' }}</small>
                    @if (Gate::allows('post-show'))
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">Show</a>
                    @endif

                    @if (Gate::allows('post-edit'))
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm">Edit</a>
                    @endif

                    @if (Gate::allows('post-delete'))
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif

                    @if (Gate::allows('post-approve'))
                        <a href="{{ route('post.approve', $post) }}" class="btn btn-secondary btn-sm">Approve</a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endsection
