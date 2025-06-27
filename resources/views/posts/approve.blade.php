@extends('layouts.app')

@section('content')
    <h2> Post Approve</h2>

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" readonly value="{{ $post->title ?? '' }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Body</label>
        <textarea name="body" class="form-control" readonly>{{ $post->body ?? '' }}</textarea>
    </div>

    <button type="button" class="btn btn-success">Approve</button>
@endsection
