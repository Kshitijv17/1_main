<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users and products
        $users = User::where('role', 'user')->take(5)->get();
        $products = Product::where('is_active', true)->take(3)->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found. Skipping review seeding.');
            return;
        }

        $reviewData = [
            [
                'rating' => 5,
                'title' => 'Excellent Product!',
                'comment' => 'This product exceeded my expectations. Great quality and fast delivery. Highly recommended!',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 4,
                'title' => 'Very Good Quality',
                'comment' => 'Good product overall. The quality is solid and it works as described. Would buy again.',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 5,
                'title' => 'Amazing Value',
                'comment' => 'Perfect product for the price. Great customer service and quick shipping. Very satisfied with my purchase.',
                'is_verified' => false,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 3,
                'title' => 'Average Product',
                'comment' => 'The product is okay, nothing special. It does what it\'s supposed to do but could be better.',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 4,
                'title' => 'Good Purchase',
                'comment' => 'Happy with this purchase. Good quality and reasonable price. Delivery was on time.',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 5,
                'title' => 'Outstanding!',
                'comment' => 'Absolutely love this product! Best purchase I\'ve made in a while. The quality is top-notch.',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 2,
                'title' => 'Not as Expected',
                'comment' => 'The product didn\'t meet my expectations. Quality could be better for the price.',
                'is_verified' => false,
                'is_approved' => true,
                'helpful_votes' => []
            ],
            [
                'rating' => 4,
                'title' => 'Solid Choice',
                'comment' => 'Good product with reliable performance. Would recommend to others looking for this type of item.',
                'is_verified' => true,
                'is_approved' => true,
                'helpful_votes' => []
            ]
        ];

        $reviewIndex = 0;
        
        // Create reviews for each product
        foreach ($products as $product) {
            // Create 2-3 reviews per product
            $reviewCount = rand(2, 3);
            
            for ($i = 0; $i < $reviewCount && $reviewIndex < count($reviewData); $i++) {
                $user = $users->random();
                
                // Check if this user already reviewed this product
                $existingReview = Review::where('user_id', $user->id)
                                      ->where('product_id', $product->id)
                                      ->first();
                
                if (!$existingReview) {
                    Review::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'rating' => $reviewData[$reviewIndex]['rating'],
                        'title' => $reviewData[$reviewIndex]['title'],
                        'comment' => $reviewData[$reviewIndex]['comment'],
                        'is_verified' => $reviewData[$reviewIndex]['is_verified'],
                        'is_approved' => $reviewData[$reviewIndex]['is_approved'],
                        'helpful_votes' => $reviewData[$reviewIndex]['helpful_votes'],
                    ]);
                    
                    $reviewIndex++;
                }
            }
        }

        $this->command->info('Review seeding completed successfully.');
    }
}
