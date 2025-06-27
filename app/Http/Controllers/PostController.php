<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        if (!Gate::allows('post-list')) {
            abort(403);
        }

        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        if (!Gate::allows('post-create')) {
            abort(403);
        }

        return view('posts.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('post-create')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        // Auth::user()->posts()->create($request->only('title', 'body'));
        $request->user()->posts()->create($request->only('title', 'body'));

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    public function show(Post $post)
    {
        if (!Gate::allows('post-show')) {
            abort(403);
        }

        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        if (!Gate::allows('post-edit')) {
            abort(403);
        }

        return view('posts.create', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (!Gate::allows('post-edit')) {
            abort(403);
        }


        $post->update($request->only('title', 'body'));
        return redirect()->route('posts.index')->with('success', 'Updated!');
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('post-delete')) {
            abort(403);
        }

        $post->delete();
        return back()->with('success', 'Deleted!');
    }

    public function approve($postId)
    {
        $post = Post::find($postId);
        if (!Gate::allows('post-approve')) {
            abort(403);
        }

        return view('posts.approve', ['post' => $post]);
    }
}
