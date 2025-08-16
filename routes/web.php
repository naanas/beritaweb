<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController; // Import UserController admin
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('post.show');
Route::post('/berita/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Admin Routes (Rute yang memerlukan login dan memiliki prefix 'admin' serta nama rute 'admin.')
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Rute Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Resource untuk Manajemen Artikel (CRUD)
    Route::resource('posts', AdminPostController::class);

    // Rute Resource untuk Manajemen Kategori (CRUD)
    Route::resource('categories', AdminCategoryController::class);

    // --- PENTING: TAMBAHKAN BARIS INI ---
    // Rute Resource untuk Manajemen Pengguna (CRUD)
    Route::resource('users', AdminUserController::class)->except(['show']); // Tidak perlu show untuk user admin

    // Rute Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Menggunakan rute dari Breeze auth.php
require __DIR__.'/auth.php';