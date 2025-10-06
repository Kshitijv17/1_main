<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all active categories
     */
    public function index(Request $request)
    {
        try {
            $query = Category::where('status', 'active');

            // Filter for homepage categories
            if ($request->has('show_on_home') && $request->show_on_home) {
                $query->where('show_on_home', true);
            }

            $categories = $query->orderBy('sort_order', 'asc')
                               ->orderBy('title', 'asc')
                               ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single category with products
     */
    public function show($id, Request $request)
    {
        try {
            $category = Category::where('status', 'active')->findOrFail($id);
            
            // Get products count for this category
            $productsCount = $category->products()
                ->where('is_active', true)
                ->where('stock_status', 'in_stock')
                ->count();

            // Get sample products (optional)
            $sampleProducts = [];
            if ($request->has('include_products')) {
                $sampleProducts = $category->products()
                    ->with(['shop', 'images'])
                    ->where('is_active', true)
                    ->where('stock_status', 'in_stock')
                    ->orderBy('is_featured', 'desc')
                    ->limit(8)
                    ->get();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => $category,
                    'products_count' => $productsCount,
                    'sample_products' => $sampleProducts
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get categories with product counts
     */
    public function withProductCounts()
    {
        try {
            $categories = Category::where('status', 'active')
                ->withCount(['products' => function($query) {
                    $query->where('is_active', true)
                          ->where('stock_status', 'in_stock');
                }])
                ->orderBy('sort_order', 'asc')
                ->orderBy('title', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories with counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get featured categories for homepage
     */
    public function featured()
    {
        try {
            $categories = Category::where('status', 'active')
                ->where('show_on_home', true)
                ->withCount(['products' => function($query) {
                    $query->where('is_active', true)
                          ->where('stock_status', 'in_stock');
                }])
                ->orderBy('sort_order', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
