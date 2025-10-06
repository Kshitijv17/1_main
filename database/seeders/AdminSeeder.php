<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('admin123'),
            'role' => UserRole::ADMIN,
            'is_guest' => false,
        ]);

        // Create Regular Admin
        User::create([
            'name' => 'Admin Boss',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => UserRole::ADMIN,
            'is_guest' => false,
        ]);
    }
}
