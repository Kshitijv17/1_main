<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Enums\UserRole;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create admin users (vendors)
        $admins = User::where('role', 'admin')->get();
        
        if ($admins->count() < 3) {
            // Create sample admin users if we don't have enough
            $existingEmails = $admins->pluck('email')->toArray();
            $newAdmins = [];
            
            $sampleAdmins = [
                ['name' => 'John Smith', 'email' => 'john.shop@example.com'],
                ['name' => 'Sarah Johnson', 'email' => 'sarah.shop@example.com'],
                ['name' => 'Mike Wilson', 'email' => 'mike.shop@example.com'],
            ];
            
            foreach ($sampleAdmins as $adminData) {
                if (!in_array($adminData['email'], $existingEmails)) {
                    $newAdmins[] = User::create([
                        'name' => $adminData['name'],
                        'email' => $adminData['email'],
                        'password' => bcrypt('password'),
                        'role' => UserRole::ADMIN,
                        'email_verified_at' => now(),
                    ]);
                }
            }
            
            $admins = $admins->merge($newAdmins);
        }

        $shops = [
            [
                'name' => 'Herbal Wellness Store',
                'slug' => 'herbal-wellness-store',
                'description' => 'Your trusted source for authentic herbal products and natural wellness solutions. We specialize in traditional ayurvedic remedies and organic health products.',
                'address' => '123 Wellness Street, Ayurveda City, IN 110001',
                'phone' => '+91-9876543210',
                'email' => 'info@herbalwellness.com',
                'website' => 'https://herbalwellness.com',
                'vendor_id' => $admins->first()->id,
                'commission_rate' => 8.5,
                'is_active' => true,
            ],
            [
                'name' => 'Natural Beauty Hub',
                'slug' => 'natural-beauty-hub',
                'description' => 'Premium natural beauty and skincare products made from pure herbal ingredients. Discover the power of nature for your beauty routine.',
                'address' => '456 Beauty Lane, Natural City, IN 110002',
                'phone' => '+91-9876543211',
                'email' => 'hello@naturalbeautyhub.com',
                'website' => 'https://naturalbeautyhub.com',
                'vendor_id' => $admins->skip(1)->first()->id,
                'commission_rate' => 12.0,
                'is_active' => true,
            ],
            [
                'name' => 'Organic Life Store',
                'slug' => 'organic-life-store',
                'description' => 'Complete range of organic and natural products for a healthy lifestyle. From supplements to home care, we have everything natural.',
                'address' => '789 Organic Avenue, Green City, IN 110003',
                'phone' => '+91-9876543212',
                'email' => 'support@organiclifestore.com',
                'website' => 'https://organiclifestore.com',
                'vendor_id' => $admins->skip(2)->first()->id,
                'commission_rate' => 10.0,
                'is_active' => true,
            ],
        ];

        foreach ($shops as $shopData) {
            $shop = Shop::create($shopData);
            
            // Create sample products for each shop
            $this->createSampleProducts($shop);
        }

        $this->command->info('Created ' . count($shops) . ' sample shops with products.');
    }

    /**
     * Create sample products for a shop
     */
    private function createSampleProducts(Shop $shop)
    {
        $products = [];

        if ($shop->name === 'Herbal Wellness Store') {
            $products = [
                [
                    'title' => 'Organic Neem Hair Oil',
                    'slug' => 'organic-neem-hair-oil',
                    'description' => 'Pure neem oil enriched with natural herbs for healthy hair growth and dandruff control.',
                    'features' => 'Anti-dandruff, Hair growth, Natural ingredients, Chemical-free',
                    'specifications' => 'Volume: 200ml, Ingredients: Neem, Coconut oil, Brahmi, Bhringraj',
                    'price' => 299.00,
                    'selling_price' => 249.00,
                    'quantity' => 50,
                    'category_id' => 1, // Hair Care
                    'sku' => 'HWS-NEEM-001',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Ayurvedic Immunity Booster Powder',
                    'slug' => 'ayurvedic-immunity-booster-powder',
                    'description' => 'Traditional herbal blend to boost immunity and overall health naturally.',
                    'features' => 'Immunity boost, Natural herbs, Traditional recipe, Daily wellness',
                    'specifications' => 'Weight: 500g, Ingredients: Ashwagandha, Giloy, Tulsi, Amla',
                    'price' => 599.00,
                    'selling_price' => 499.00,
                    'quantity' => 30,
                    'category_id' => 9, // Immunity Boosters
                    'sku' => 'HWS-IMM-001',
                    'is_featured' => false,
                ],
                [
                    'title' => 'Herbal Digestive Tea',
                    'slug' => 'herbal-digestive-tea',
                    'description' => 'Soothing herbal tea blend for better digestion and gut health.',
                    'features' => 'Digestive aid, Caffeine-free, Natural herbs, Refreshing taste',
                    'specifications' => 'Weight: 100g, Ingredients: Fennel, Ginger, Mint, Cardamom',
                    'price' => 199.00,
                    'selling_price' => 179.00,
                    'quantity' => 75,
                    'category_id' => 6, // Herbal Teas
                    'sku' => 'HWS-TEA-001',
                    'is_featured' => false,
                ],
            ];
        } elseif ($shop->name === 'Natural Beauty Hub') {
            $products = [
                [
                    'title' => 'Rose & Sandalwood Face Pack',
                    'slug' => 'rose-sandalwood-face-pack',
                    'description' => 'Natural face pack with rose petals and sandalwood for glowing skin.',
                    'features' => 'Skin brightening, Anti-aging, Natural glow, Chemical-free',
                    'specifications' => 'Weight: 100g, Ingredients: Rose petals, Sandalwood, Multani mitti, Turmeric',
                    'price' => 399.00,
                    'selling_price' => 349.00,
                    'quantity' => 40,
                    'category_id' => 2, // Skin Care
                    'sku' => 'NBH-FACE-001',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Lavender Essential Oil',
                    'slug' => 'lavender-essential-oil',
                    'description' => 'Pure lavender essential oil for aromatherapy and relaxation.',
                    'features' => 'Aromatherapy, Relaxation, Pure essential oil, Therapeutic grade',
                    'specifications' => 'Volume: 30ml, Purity: 100%, Origin: Organic farms',
                    'price' => 799.00,
                    'selling_price' => 699.00,
                    'quantity' => 25,
                    'category_id' => 7, // Essential Oils
                    'sku' => 'NBH-ESS-001',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Aloe Vera Gel',
                    'slug' => 'aloe-vera-gel',
                    'description' => 'Pure aloe vera gel for skin hydration and healing.',
                    'features' => 'Skin hydration, Healing properties, Natural moisturizer, Multi-purpose',
                    'specifications' => 'Volume: 250ml, Purity: 99% Aloe vera, Preservative-free',
                    'price' => 249.00,
                    'selling_price' => 199.00,
                    'quantity' => 60,
                    'category_id' => 2, // Skin Care
                    'sku' => 'NBH-ALOE-001',
                    'is_featured' => false,
                ],
            ];
        } else { // Organic Life Store
            $products = [
                [
                    'title' => 'Organic Turmeric Powder',
                    'slug' => 'organic-turmeric-powder',
                    'description' => 'Premium quality organic turmeric powder with high curcumin content.',
                    'features' => 'High curcumin, Anti-inflammatory, Organic certified, Pure quality',
                    'specifications' => 'Weight: 500g, Curcumin content: 3-5%, Organic certified',
                    'price' => 299.00,
                    'selling_price' => 249.00,
                    'quantity' => 80,
                    'category_id' => 3, // Ayurvedic Powders
                    'sku' => 'OLS-TUR-001',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Coconut Oil (Cold Pressed)',
                    'slug' => 'coconut-oil-cold-pressed',
                    'description' => 'Virgin coconut oil extracted through cold pressing method for maximum nutrition.',
                    'features' => 'Cold pressed, Virgin quality, Multi-purpose, Natural extraction',
                    'specifications' => 'Volume: 500ml, Extraction: Cold pressed, Quality: Virgin',
                    'price' => 399.00,
                    'selling_price' => 349.00,
                    'quantity' => 45,
                    'category_id' => 4, // Herbal Oils
                    'sku' => 'OLS-COC-001',
                    'is_featured' => false,
                ],
                [
                    'title' => 'Bamboo Toothbrush Set',
                    'slug' => 'bamboo-toothbrush-set',
                    'description' => 'Eco-friendly bamboo toothbrushes for sustainable oral care.',
                    'features' => 'Eco-friendly, Biodegradable, Sustainable, Natural bristles',
                    'specifications' => 'Pack: 4 pieces, Material: Bamboo handle, Bristles: Natural',
                    'price' => 199.00,
                    'selling_price' => 149.00,
                    'quantity' => 100,
                    'category_id' => 10, // Home Décor
                    'sku' => 'OLS-BAMB-001',
                    'is_featured' => false,
                ],
            ];
        }

        foreach ($products as $productData) {
            $productData['shop_id'] = $shop->id;
            $productData['is_active'] = true;
            $productData['stock_status'] = $productData['quantity'] > 0 ? 'in_stock' : 'out_of_stock';
            
            Product::create($productData);
        }
    }
}
