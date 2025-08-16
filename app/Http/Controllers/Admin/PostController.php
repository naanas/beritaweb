<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post; // Import Post Model
use App\Models\Category; // Import Category Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk helper Str::slug
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Validation\Rule; // Untuk validasi unique slug pada update

class PostController extends Controller
{
    /**
     * Display a listing of the resource (articles).
     */
    public function index()
    {
        $posts = Post::with('category', 'user')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource (article).
     */
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori untuk dropdown
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource (article) in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Pastikan ID kategori ada
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'published_at' => 'nullable|date',
        ]);

        // Buat slug dari judul
        $validatedData['slug'] = Str::slug($request->title);

        // Cek apakah slug sudah ada, tambahkan angka jika duplikat
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Post::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public'); // Simpan di storage/app/public/posts
            $validatedData['image'] = Storage::url($imagePath); // Dapatkan URL publik
        }

        // Set user_id dari user yang sedang login
        $validatedData['user_id'] = auth()->id();

        // Buat post baru
        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (article).
     * (Biasanya tidak diperlukan untuk admin panel, tapi bisa diimplementasikan)
     */
    public function show(Post $post)
    {
        // Anda bisa mengarahkan ke halaman detail publik atau ke halaman edit
        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Show the form for editing the specified resource (article).
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource (article) in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            // Validasi slug agar unique kecuali slug dari post yang sedang diedit
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete(Str::after($post->image, '/storage/'));
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $validatedData['image'] = Storage::url($imagePath);
        } else {
            // Jika tidak ada gambar baru, pertahankan gambar lama
            $validatedData['image'] = $post->image;
        }

        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource (article) from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar terkait jika ada
        if ($post->image) {
            Storage::disk('public')->delete(Str::after($post->image, '/storage/'));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dihapus!');
    }
}