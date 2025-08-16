<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post; // Import model Post
use App\Models\Category; // Import model Category
use App\Models\User; // Import model User
use Carbon\Carbon; // Untuk tanggal

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user dan category
        $user = User::first() ?? User::factory()->create(); // Buat user jika belum ada
        $categoryTech = Category::where('slug', 'teknologi')->first();
        $categoryPol = Category::where('slug', 'politik')->first();

        if ($user && $categoryTech && $categoryPol) {
            Post::create([
                'category_id' => $categoryTech->id,
                'user_id' => $user->id,
                'title' => 'Inovasi Terbaru AI Mengubah Industri',
                'slug' => 'inovasi-terbaru-ai-mengubah-industri',
                'image' => 'https://via.placeholder.com/600x400?text=AI+Inovasi',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'published_at' => Carbon::now()->subDays(5),
            ]);

            Post::create([
                'category_id' => $categoryPol->id,
                'user_id' => $user->id,
                'title' => 'Debat Politik Panas Jelang Pemilu',
                'slug' => 'debat-politik-panas-jelang-pemilu',
                'image' => 'https://via.placeholder.com/600x400?text=Debat+Politik',
                'content' => 'Nullam nec lectus et mi tempor eleifend. Mauris sit amet lorem quis sapien scelerisque volutpat. Praesent congue, dui a malesuada semper, felis justo egestas velit, vel laoreet justo nulla sit amet eros. Integer id odio eu sem fermentum lacinia. Sed dictum vel odio in hendrerit.',
                'published_at' => Carbon::now()->subDays(2),
            ]);

            Post::create([
                'category_id' => $categoryTech->id,
                'user_id' => $user->id,
                'title' => 'Smartphone Lipat Terbaru Dirilis',
                'slug' => 'smartphone-lipat-terbaru-dirilis',
                'image' => 'https://via.placeholder.com/600x400?text=Smartphone+Lipat',
                'content' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus at diam vel erat scelerisque placerat non vel enim. Aenean et nisl ac risus dapibus tincidunt. Integer at turpis sed nisi gravida egestas.',
                'published_at' => Carbon::now()->subHours(10),
            ]);
        }
    }
}