<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
{
    $this->call([
        UserSeeder::class,
        AdminSeeder::class,
        HerbalCategorySeeder::class,
        ShopSeeder::class, // This will create shops and products
        ReviewSeeder::class, // Add reviews after products are created
        // SimpleHerbalProductSeeder::class,
        // Keep original seeders as backup
        // CategorySeeder::class,
        // ProductSeeder::class,
    ]);
}

}
