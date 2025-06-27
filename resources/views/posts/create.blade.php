@extends('layouts.app')

@section('content')
    <h2>{{ isset($post) ? 'Edit' : 'Create' }} Post</h2>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" value="{{ $post->title ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control">{{ $post->body ?? '' }}</textarea>
        </div>

        <button class="btn btn-success">Submit</button>
    </form>
@endsection
