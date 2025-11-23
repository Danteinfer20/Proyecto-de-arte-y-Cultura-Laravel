<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Category::where('type', 'post')
            ->where('is_active', true)
            ->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show($id)
    {
        $post = Post::with(['category', 'user', 'tags'])
            ->findOrFail($id);

        // Incrementar contador de vistas
        $post->increment('view_count');

        return view('posts.show', compact('post'));
    }
}