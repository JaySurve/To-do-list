<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Display all posts
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create($request->all());

        return response()->json(['success' => 'Post created successfully']);
    }

    // Show a specific post
    public function show($id)
    {
        return response()->json(Post::find($id));
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());

        return response()->json(['success' => 'Post updated successfully']);
    }

    // Delete a post
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json(['success' => 'Post deleted successfully']);
    }
}
