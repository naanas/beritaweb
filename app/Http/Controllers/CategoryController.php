<?php

namespace App\Http\Controllers;

use App\Models\Category; // Import model Category
use App\Models\Post;     // Import model Post
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of posts by a specific category.
     *
     * @param  string  $slug The slug of the category.
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        // Cari kategori berdasarkan slug, atau tampilkan 404 jika tidak ditemukan
        $category = Category::where('slug', $slug)->firstOrFail();

        // Ambil berita yang termasuk dalam kategori ini, yang sudah dipublikasi
        // dan urutkan dari yang terbaru, lalu lakukan pagination.
        $posts = Post::with(['category', 'user']) // Eager load category dan user
                      ->where('category_id', $category->id) // Filter berdasarkan ID kategori
                      ->whereNotNull('published_at') // Pastikan sudah dipublikasi
                      ->where('published_at', '<=', now()) // Pastikan tanggal publikasi sudah lewat
                      ->latest() // Urutkan dari yang terbaru
                      ->paginate(10); // Tampilkan 10 berita per halaman

        // Kirim data kategori dan posts ke tampilan
        return view('category.show', compact('category', 'posts'));
    }
}