<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Rollar allaqachon mavjud bo'lmasa yaratish
        if (Role::where('name', 'Admin')->doesntExist()) {
            $adminRole = Role::create(['name' => 'Admin']);
        } else {
            $adminRole = Role::where('name', 'Admin')->first();
        }

        if (Role::where('name', 'Accountant')->doesntExist()) {
            $accountantRole = Role::create(['name' => 'Accountant']);
        } else {
            $accountantRole = Role::where('name', 'Accountant')->first();
        }

        if (Role::where('name', 'Reception')->doesntExist()) {
            $receptionRole = Role::create(['name' => 'Reception']);
        } else {
            $receptionRole = Role::where('name', 'Reception')->first();
        }

        // Ruxsatlarni yaratish
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'manage bookings']);

        // Ruxsatlarni rollarga biriktirish
        $adminRole->syncPermissions(['manage users', 'view reports', 'manage bookings']);
        $accountantRole->syncPermissions(['view reports']);
        $receptionRole->syncPermissions(['manage bookings']);

        // Foydalanuvchilarni yaratish va ularga rollarni tayinlash
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password')
            ]
        );
        $adminUser->assignRole('Admin');

        $accountantUser = User::firstOrCreate(
            ['email' => 'accountant@example.com'],
            [
                'name' => 'Accountant User',
                'password' => bcrypt('password')
            ]
        );
        $accountantUser->assignRole('Accountant');

        $receptionUser = User::firstOrCreate(
            ['email' => 'reception@example.com'],
            [
                'name' => 'Reception User',
                'password' => bcrypt('password')
            ]
        );
        $receptionUser->assignRole('Reception');
    }
}


