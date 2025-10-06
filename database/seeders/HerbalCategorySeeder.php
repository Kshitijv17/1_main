<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class HerbalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Hair Care',
                'slug' => 'hair-care',
                'description' => 'Natural hair care products for healthy and beautiful hair',
                'image' => 'categories/hair-care.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Skin Care',
                'slug' => 'skin-care',
                'description' => 'Herbal skin care solutions for glowing skin',
                'image' => 'categories/skin-care.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Ayurvedic Powders',
                'slug' => 'ayurvedic-powders',
                'description' => 'Traditional ayurvedic powders for health and wellness',
                'image' => 'categories/ayurvedic-powders.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Herbal Oils',
                'slug' => 'herbal-oils',
                'description' => 'Pure herbal oils for therapeutic benefits',
                'image' => 'categories/herbal-oils.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Natural Supplements',
                'slug' => 'natural-supplements',
                'description' => 'Natural health supplements for daily wellness',
                'image' => 'categories/supplements.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Herbal Teas',
                'slug' => 'herbal-teas',
                'description' => 'Refreshing herbal teas for health and relaxation',
                'image' => 'categories/herbal-teas.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Essential Oils',
                'slug' => 'essential-oils',
                'description' => 'Pure essential oils for aromatherapy and wellness',
                'image' => 'categories/essential-oils.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 7,
            ],
            [
                'title' => 'Digestive Health',
                'slug' => 'digestive-health',
                'description' => 'Natural products for digestive wellness',
                'image' => 'categories/digestive-health.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 8,
            ],
            [
                'title' => 'Immunity Boosters',
                'slug' => 'immunity-boosters',
                'description' => 'Natural immunity boosting products',
                'image' => 'categories/immunity-boosters.jpg',
                'status' => 'active',
                'show_on_home' => true,
                'sort_order' => 9,
            ],
            [
                'title' => 'Home Décor',
                'slug' => 'home-decor',
                'description' => 'Natural and eco-friendly home décor items',
                'image' => 'categories/home-decor.jpg',
                'status' => 'active',
                'show_on_home' => false,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
