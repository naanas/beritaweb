<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use App\Models\Category; // Import Model Category
use Illuminate\Pagination\Paginator; // Import Paginator untuk styling pagination

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer untuk membuat variabel 'categories' tersedia di view 'layouts.app'
        // Ini akan mengambil semua kategori yang diurutkan berdasarkan nama
        View::composer('layouts.public_app', function ($view) {
            $categories = Category::orderBy('name')->get();
            $view->with('categories', $categories);
        });

        // Menggunakan Bootstrap untuk styling pagination (opsional, jika Anda menggunakan Bootstrap CSS)
        // Jika Anda menggunakan Tailwind CSS (default Laravel 10+), baris ini tidak perlu
        Paginator::useBootstrapFive(); // atau useBootstrapFour();
    }
}