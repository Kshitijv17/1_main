<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Cool User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::USER,
            'is_guest' => false,
        ]);
    }
}

