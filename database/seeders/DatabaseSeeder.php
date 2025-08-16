<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User admin@example.com akan dibuat di RolesAndPermissionsSeeder
        // Jika Anda sebelumnya memiliki User::firstOrCreate di sini, hapus atau komentari
        // User::firstOrCreate(
        //     ['email' => 'ad@ad.com'],
        //     [
        //         'name' => 'Admin User',
        //         'password' => bcrypt('123'),
        //     ]
        // );

        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
        ]);
    }
}