<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import model Post
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 10 berita terbaru yang sudah dipublikasi, dengan kategori dan user
        $posts = Post::with(['category', 'user'])
                      ->whereNotNull('published_at')
                      ->where('published_at', '<=', now())
                      ->latest() // Urutkan dari yang terbaru
                      ->paginate(10); // Tampilkan 10 per halaman

        return view('index', compact('posts'));
    }
}