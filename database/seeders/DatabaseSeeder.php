<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class, // Jika Anda memiliki seeder user sendiri
            RolesAndPermissionsSeeder::class, // <-- Panggil seeder ini
            // CategorySeeder::class, // Contoh, jika Anda punya seeder lain
            // PostSeeder::class,
        ]);
    }
}