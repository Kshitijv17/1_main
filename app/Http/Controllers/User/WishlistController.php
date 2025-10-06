<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $wishlistItems = auth('web')->user()->wishlistProducts()
            ->with(['shop', 'images', 'category'])
            ->paginate(12);

        return view('user.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth('web')->user();
        $productId = $request->product_id;

        // Check if already in wishlist
        if ($user->hasInWishlist($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist!'
            ], 409);
        }

        // Add to wishlist
        $user->wishlists()->create([
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'wishlist_count' => $user->wishlists()->count()
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth('web')->user();
        $productId = $request->product_id;

        $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist!'
            ], 404);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist!',
            'wishlist_count' => $user->wishlists()->count()
        ]);
    }

    /**
     * Toggle product in wishlist (add if not present, remove if present)
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth('web')->user();
        $productId = $request->product_id;

        if ($user->hasInWishlist($productId)) {
            // Remove from wishlist
            $user->wishlists()->where('product_id', $productId)->delete();
            
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from wishlist!',
                'wishlist_count' => $user->wishlists()->count()
            ]);
        } else {
            // Add to wishlist
            $user->wishlists()->create([
                'product_id' => $productId
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Product added to wishlist!',
                'wishlist_count' => $user->wishlists()->count()
            ]);
        }
    }

    /**
     * Get wishlist count for header
     */
    public function count(): JsonResponse
    {
        $count = auth('web')->user()->wishlists()->count();
        
        return response()->json([
            'count' => $count
        ]);
    }
}
