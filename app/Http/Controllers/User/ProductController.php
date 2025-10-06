<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with filtering and sorting
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'shop'])
                       ->where('is_active', true)
                       ->whereHas('shop', function($q) {
                           $q->where('is_active', true);
                       });

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('features', 'like', '%' . $searchTerm . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where('selling_price', '>=', $request->min_price)
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->whereNull('selling_price')
                           ->where('price', '>=', $request->min_price);
                  });
            });
        }

        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where('selling_price', '<=', $request->max_price)
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->whereNull('selling_price')
                           ->where('price', '<=', $request->max_price);
                  });
            });
        }

        // Stock filter
        if ($request->boolean('in_stock')) {
            $query->where('stock_status', 'in_stock')
                  ->where('quantity', '>', 0);
        }

        // Sorting
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'price_asc':
                $query->orderByRaw('COALESCE(selling_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(selling_price, price) DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results
        $products = $query->paginate(12);

        return view('user.products', compact('products'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        // Check if product is active and shop is active
        if (!$product->is_active || !$product->shop->is_active) {
            abort(404, 'Product not found or unavailable');
        }

        // Load relationships including reviews
        $product->load(['category', 'shop', 'approvedReviews.user']);

        // Get related products from the same category
        $relatedProducts = Product::with(['category', 'shop'])
                                 ->where('is_active', true)
                                 ->where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->whereHas('shop', function($q) {
                                     $q->where('is_active', true);
                                 })
                                 ->limit(4)
                                 ->get();

        // Get more products from the same shop
        $shopProducts = Product::with(['category'])
                              ->where('is_active', true)
                              ->where('shop_id', $product->shop_id)
                              ->where('id', '!=', $product->id)
                              ->limit(4)
                              ->get();

        // Calculate discount percentage if applicable
        $discountPercentage = 0;
        if ($product->discount_price && $product->discount_price < $product->price) {
            $discountPercentage = round((($product->price - $product->discount_price) / $product->price) * 100);
        }

        // Get final price (discount price if available, otherwise regular price)
        $finalPrice = $product->discount_price && $product->discount_price < $product->price 
                     ? $product->discount_price 
                     : $product->price;

        // Get actual reviews and rating data
        $reviews = $product->approvedReviews()->with('user')->latest()->get();
        $averageRating = $product->average_rating;

        return view('user.product', compact(
            'product', 
            'relatedProducts', 
            'shopProducts', 
            'discountPercentage', 
            'finalPrice',
            'reviews',
            'averageRating'
        ));
    }

    /**
     * Search products (AJAX endpoint)
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with(['category', 'shop'])
                          ->where('is_active', true)
                          ->where(function($q) use ($query) {
                              $q->where('title', 'like', '%' . $query . '%')
                                ->orWhere('description', 'like', '%' . $query . '%');
                          })
                          ->whereHas('shop', function($q) {
                              $q->where('is_active', true);
                          })
                          ->limit(10)
                          ->get()
                          ->map(function($product) {
                              return [
                                  'id' => $product->id,
                                  'name' => $product->title,
                                  'price' => $product->selling_price ?? $product->price,
                                  'discount_price' => $product->price,
                                  'image' => $product->image ? asset('storage/' . $product->image) : null,
                                  'shop_name' => $product->shop->name,
                                  'category_name' => $product->category->title ?? 'Uncategorized',
                                  'url' => route('user.product.show', $product)
                              ];
                          });

        return response()->json($products);
    }
}
