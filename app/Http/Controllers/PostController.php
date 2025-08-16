<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import model Post
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(string $slug)
    {
        // Cari berita berdasarkan slug, dengan memuat kategori, user, dan komentar
        $post = Post::with(['category', 'user', 'comments.user'])
                    ->where('slug', $slug)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->firstOrFail(); // Akan 404 jika tidak ditemukan

        return view('post.show', compact('post'));
    }
}