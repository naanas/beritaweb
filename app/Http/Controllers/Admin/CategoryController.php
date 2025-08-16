<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Import model Category
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk helper Str::slug
use Illuminate\Validation\Rule; // Untuk validasi unique slug pada update

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource (categories).
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10); // Ambil semua kategori, urutkan terbaru, paginate
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource (category).
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource (category) in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Nama harus unik
            'slug' => 'nullable|string|max:255|unique:categories,slug', // Slug harus unik, bisa null jika otomatis
        ]);

        // Jika slug tidak diisi, buat otomatis dari nama
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($request->name);
        }

        // Pastikan slug unik, tambahkan angka jika duplikat
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Category::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (category).
     * Tidak terlalu relevan untuk admin panel, biasanya redirect ke halaman edit atau daftar.
     */
    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Show the form for editing the specified resource (category).
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource (category) in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $validatedData = $request->validate([
            // Nama harus unik kecuali nama dari kategori yang sedang diedit
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            // Slug harus unik kecuali slug dari kategori yang sedang diedit
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource (category) from storage.
     */
    public function destroy(Category $category)
    {
        // Sebelum menghapus kategori, pertimbangkan apa yang terjadi pada artikel
        // yang terkait dengan kategori ini. Di migrasi kita, category_id di posts
        // memiliki ON DELETE CASCADE, artinya artikel terkait juga akan terhapus.
        // Jika Anda tidak ingin artikel terhapus, Anda perlu mengubah migrasi
        // atau mengaitkan artikel tersebut ke kategori default sebelum menghapus.

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}