<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products with filtering and pagination
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with(['category', 'shop', 'images'])
                ->where('is_active', true)
                ->where('stock_status', 'in_stock');

            // Filter by category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Filter by shop
            if ($request->has('shop_id')) {
                $query->where('shop_id', $request->shop_id);
            }

            // Search by title or description
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('features', 'like', "%{$search}%");
                });
            }

            // Price range filter
            if ($request->has('min_price')) {
                $query->where('selling_price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('selling_price', '<=', $request->max_price);
            }

            // Featured products filter
            if ($request->has('featured') && $request->featured) {
                $query->where('is_featured', true);
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            switch ($sortBy) {
                case 'price_low_to_high':
                    $query->orderBy('selling_price', 'asc');
                    break;
                case 'price_high_to_low':
                    $query->orderBy('selling_price', 'desc');
                    break;
                case 'popularity':
                    $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy($sortBy, $sortOrder);
            }

            $perPage = $request->get('per_page', 20);
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single product details
     */
    public function show($id)
    {
        try {
            $product = Product::with(['category', 'shop', 'images'])
                ->where('is_active', true)
                ->findOrFail($id);

            // Get related products from same category
            $relatedProducts = Product::with(['images'])
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->where('stock_status', 'in_stock')
                ->limit(8)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'product' => $product,
                    'related_products' => $relatedProducts
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get featured products
     */
    public function featured(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            
            $products = Product::with(['category', 'shop', 'images'])
                ->where('is_active', true)
                ->where('is_featured', true)
                ->where('stock_status', 'in_stock')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by category
     */
    public function byCategory($categoryId, Request $request)
    {
        try {
            $category = Category::findOrFail($categoryId);
            
            $query = Product::with(['shop', 'images'])
                ->where('category_id', $categoryId)
                ->where('is_active', true)
                ->where('stock_status', 'in_stock');

            // Apply filters similar to index method
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($request->has('min_price')) {
                $query->where('selling_price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('selling_price', '<=', $request->max_price);
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            switch ($sortBy) {
                case 'price_low_to_high':
                    $query->orderBy('selling_price', 'asc');
                    break;
                case 'price_high_to_low':
                    $query->orderBy('selling_price', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->get('per_page', 20);
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => $category,
                    'products' => $products
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch category products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by shop
     */
    public function byShop($shopId, Request $request)
    {
        try {
            $shop = Shop::findOrFail($shopId);
            
            $query = Product::with(['category', 'images'])
                ->where('shop_id', $shopId)
                ->where('is_active', true)
                ->where('stock_status', 'in_stock');

            // Apply filters
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $sortBy = $request->get('sort_by', 'created_at');
            switch ($sortBy) {
                case 'price_low_to_high':
                    $query->orderBy('selling_price', 'asc');
                    break;
                case 'price_high_to_low':
                    $query->orderBy('selling_price', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->get('per_page', 20);
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'shop' => $shop,
                    'products' => $products
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch shop products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:2|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query is required (minimum 2 characters)',
                    'errors' => $validator->errors()
                ], 422);
            }

            $query = $request->q;
            
            $products = Product::with(['category', 'shop', 'images'])
                ->where('is_active', true)
                ->where('stock_status', 'in_stock')
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('features', 'like', "%{$query}%")
                      ->orWhere('specifications', 'like', "%{$query}%");
                })
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => [
                    'query' => $query,
                    'products' => $products
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
