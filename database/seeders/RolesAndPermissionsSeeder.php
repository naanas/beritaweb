<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // <-- Import model User

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions (Izin)
        // Izin untuk artikel
        Permission::firstOrCreate(['name' => 'create article']);
        Permission::firstOrCreate(['name' => 'view article']);
        Permission::firstOrCreate(['name' => 'update article']);
        Permission::firstOrCreate(['name' => 'delete article']);

        // Izin untuk persetujuan artikel (Manajer)
        Permission::firstOrCreate(['name' => 'approve article']);
        Permission::firstOrCreate(['name' => 'reject article']);

        // Izin administratif tambahan
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage roles']);
        Permission::firstOrCreate(['name' => 'manage permissions']);

        // 2. Buat Roles (Peran) dan Berikan Permissions

        // Role Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin mendapatkan semua izin

        // Role Manajer
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view article',
            'approve article',
            'reject article',
            'create article', // Manajer juga bisa membuat, mengedit, menghapus jika diperlukan
            'update article',
            'delete article',
            // 'manage users', // Contoh, jika manajer bisa mengelola pengguna juga
        ]);

        // Role Karyawan
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'create article',
            'view article',
            'update article',
            'delete article',
        ]);

        // 3. Berikan Role ke Pengguna Contoh
        // Buat user contoh atau assign ke user yang sudah ada
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@beritaweb.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'), // Ganti dengan password yang kuat di production!
            ]
        );
        $adminUser->assignRole('admin');

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@beritaweb.com'],
            [
                'name' => 'Manajer Artikel',
                'password' => bcrypt('password'),
            ]
        );
        $managerUser->assignRole('manager');

        $employeeUser = User::firstOrCreate(
            ['email' => 'karyawan@beritaweb.com'],
            [
                'name' => 'Karyawan Artikel',
                'password' => bcrypt('password'),
            ]
        );
        $employeeUser->assignRole('employee');

        // Contoh user lain tanpa role spesifik (default user biasa)
        $regularUser = User::firstOrCreate(
            ['email' => 'user@beritaweb.com'],
            [
                'name' => 'Pengguna Biasa',
                'password' => bcrypt('password'),
            ]
        );
        // User ini tidak memiliki role apapun, jadi tidak memiliki izin di atas.
    }
}