<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;

class HerbalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and shops
        $hairCare = Category::where('title', 'Hair Care')->first();
        $skinCare = Category::where('title', 'Skin Care')->first();
        $ayurvedicPowders = Category::where('title', 'Ayurvedic Powders')->first();
        $herbalOils = Category::where('title', 'Herbal Oils')->first();
        $supplements = Category::where('title', 'Natural Supplements')->first();
        $herbalTeas = Category::where('title', 'Herbal Teas')->first();
        $essentialOils = Category::where('title', 'Essential Oils')->first();
        $digestiveHealth = Category::where('title', 'Digestive Health')->first();
        $immunityBoosters = Category::where('title', 'Immunity Boosters')->first();
        $homeDecor = Category::where('title', 'Home Décor')->first();

        // Get first shop or create a default one
        $shop = Shop::first();
        if (!$shop) {
            $shop = Shop::create([
                'name' => 'HerbnHouse Store',
                'description' => 'Premium herbal and natural products store',
                'is_active' => true,
                'user_id' => 1, // Assuming admin user exists
            ]);
        }

        $products = [
            // Hair Care Products
            [
                'title' => 'Natural Amla Powder for Hair Growth',
                'description' => 'Pure organic Amla powder rich in Vitamin C for healthy hair growth and shine. Made from 100% natural Indian Gooseberry.',
                'price' => 25.00,
                'selling_price' => 19.00,
                'quantity' => 100,
                'stock_status' => 'in_stock',
                'image' => 'products/amla-powder.jpg',
                'category_id' => $hairCare?->id ?? 1,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Organic Shikakai Powder - Natural Hair Cleanser',
                'description' => 'Traditional Shikakai powder for natural hair cleansing and conditioning. Gentle on scalp and promotes hair growth.',
                'price' => 22.00,
                'selling_price' => 18.00,
                'quantity' => 85,
                'stock_status' => 'in_stock',
                'image' => 'products/shikakai-powder.jpg',
                'category_id' => $hairCare?->id ?? 1,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Herbal Hair Growth Oil Blend',
                'description' => 'Powerful blend of coconut, castor, and herbal oils for hair growth and thickness. Reduces hair fall naturally.',
                'price' => 35.00,
                'selling_price' => 28.00,
                'quantity' => 60,
                'image' => 'products/hair-growth-oil.jpg',
                'category_id' => $herbalOils?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Skin Care Products
            [
                'title' => 'Pure Turmeric Powder for Glowing Skin',
                'description' => 'Premium quality turmeric powder for natural skin glow and anti-inflammatory benefits. Perfect for face masks.',
                'price' => 18.00,
                'selling_price' => 15.00,
                'quantity' => 120,
                'image' => 'products/turmeric-powder.jpg',
                'category_id' => $skinCare?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Neem Powder - Natural Skin Purifier',
                'description' => 'Pure neem powder with antibacterial properties for acne treatment and skin purification.',
                'price' => 20.00,
                'selling_price' => 16.00,
                'quantity' => 95,
                'image' => 'products/neem-powder.jpg',
                'category_id' => $skinCare?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Rose Water Toner - Natural & Pure',
                'description' => 'Pure rose water toner for hydrating and refreshing skin. Suitable for all skin types.',
                'price' => 15.00,
                'selling_price' => 12.00,
                'quantity' => 80,
                'image' => 'products/rose-water.jpg',
                'category_id' => $skinCare?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Ayurvedic Powders
            [
                'title' => 'Triphala Powder - Digestive Wellness',
                'description' => '100% natural Triphala powder for digestive health and detoxification. Traditional Ayurvedic formula.',
                'price' => 30.00,
                'selling_price' => 24.00,
                'quantity' => 70,
                'image' => 'products/triphala-powder.jpg',
                'category_id' => $ayurvedicPowders?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Ashwagandha Powder - Stress Relief',
                'description' => 'Premium Ashwagandha root powder for stress relief and energy boost. Adaptogenic herb for wellness.',
                'price' => 40.00,
                'selling_price' => 32.00,
                'quantity' => 55,
                'image' => 'products/ashwagandha-powder.jpg',
                'category_id' => $ayurvedicPowders?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Essential Oils
            [
                'title' => 'Pure Lavender Essential Oil',
                'description' => 'Therapeutic grade lavender essential oil for relaxation and aromatherapy. Promotes better sleep.',
                'price' => 45.00,
                'selling_price' => 38.00,
                'quantity' => 40,
                'image' => 'products/lavender-oil.jpg',
                'category_id' => $essentialOils?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Tea Tree Essential Oil - Antiseptic',
                'description' => 'Pure tea tree oil with natural antiseptic properties. Great for skin care and aromatherapy.',
                'price' => 35.00,
                'selling_price' => 29.00,
                'quantity' => 65,
                'image' => 'products/tea-tree-oil.jpg',
                'category_id' => $essentialOils?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Herbal Teas
            [
                'title' => 'Organic Green Tea - Antioxidant Rich',
                'description' => 'Premium organic green tea leaves rich in antioxidants. Perfect for daily wellness routine.',
                'price' => 25.00,
                'selling_price' => 20.00,
                'quantity' => 90,
                'image' => 'products/green-tea.jpg',
                'category_id' => $herbalTeas?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Chamomile Tea - Relaxation Blend',
                'description' => 'Soothing chamomile tea for relaxation and better sleep. Caffeine-free herbal blend.',
                'price' => 22.00,
                'selling_price' => 18.00,
                'quantity' => 75,
                'image' => 'products/chamomile-tea.jpg',
                'category_id' => $herbalTeas?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Immunity Boosters
            [
                'title' => 'Giloy Powder - Immunity Booster',
                'description' => 'Pure Giloy powder to boost immunity and fight infections naturally. Traditional Ayurvedic medicine.',
                'price' => 28.00,
                'selling_price' => 23.00,
                'quantity' => 85,
                'image' => 'products/giloy-powder.jpg',
                'category_id' => $immunityBoosters?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Tulsi Powder - Holy Basil',
                'description' => 'Sacred Tulsi powder for immunity, respiratory health, and overall wellness. Pure and organic.',
                'price' => 20.00,
                'selling_price' => 16.00,
                'quantity' => 100,
                'image' => 'products/tulsi-powder.jpg',
                'category_id' => $immunityBoosters?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],

            // Home Décor Products
            [
                'title' => 'Handcrafted Wooden Wall Hanging',
                'description' => 'Beautiful handcrafted wooden wall hanging for home decoration. Natural wood finish with intricate designs.',
                'price' => 85.00,
                'selling_price' => 68.00,
                'quantity' => 25,
                'image' => 'products/wooden-wall-hanging.jpg',
                'category_id' => $homeDecor?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Macrame Wall Hanging Shelf',
                'description' => 'Boho style macrame wall hanging shelf for plants and decorative items. Handwoven with cotton cord.',
                'price' => 65.00,
                'selling_price' => 52.00,
                'quantity' => 30,
                'image' => 'products/macrame-shelf.jpg',
                'category_id' => $homeDecor?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Buddha Palm Decorative Statue',
                'description' => 'Golden handcrafted Buddha palm statue for home decoration and positive energy. Spiritual décor piece.',
                'price' => 120.00,
                'selling_price' => 95.00,
                'quantity' => 15,
                'image' => 'products/buddha-palm.jpg',
                'category_id' => $homeDecor?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => true,
            ],

            // Additional Products
            [
                'title' => 'Organic Coconut Oil - Cold Pressed',
                'description' => 'Virgin coconut oil cold-pressed for cooking, hair care, and skin care. 100% pure and natural.',
                'price' => 30.00,
                'selling_price' => 25.00,
                'quantity' => 110,
                'image' => 'products/coconut-oil.jpg',
                'category_id' => $herbalOils?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Moringa Powder - Superfood',
                'description' => 'Nutrient-rich Moringa leaf powder packed with vitamins and minerals. Natural superfood supplement.',
                'price' => 35.00,
                'selling_price' => 28.00,
                'quantity' => 70,
                'image' => 'products/moringa-powder.jpg',
                'category_id' => $supplements?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Digestive Herbal Tea Blend',
                'description' => 'Special blend of digestive herbs including ginger, fennel, and mint for better digestion.',
                'price' => 24.00,
                'selling_price' => 19.00,
                'quantity' => 60,
                'image' => 'products/digestive-tea.jpg',
                'category_id' => $digestiveHealth?->id,
                'shop_id' => $shop->id,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
