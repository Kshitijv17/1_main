<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes (No Authentication Required)
Route::prefix('v1')->group(function () {
    
    // Authentication Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('guest-login', [AuthController::class, 'guestLogin']);
        
        // Protected Auth Routes
        Route::middleware('auth:api')->group(function () {
            Route::get('profile', [AuthController::class, 'profile']);
            Route::put('profile', [AuthController::class, 'updateProfile']);
            Route::post('change-password', [AuthController::class, 'changePassword']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });
    });

    // Product Routes (Public)
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('featured', [ProductController::class, 'featured']);
        Route::get('search', [ProductController::class, 'search']);
        Route::get('category/{categoryId}', [ProductController::class, 'byCategory']);
        Route::get('shop/{shopId}', [ProductController::class, 'byShop']);
        Route::get('{id}', [ProductController::class, 'show']);
    });

    // Category Routes (Public)
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('featured', [CategoryController::class, 'featured']);
        Route::get('with-counts', [CategoryController::class, 'withProductCounts']);
        Route::get('{id}', [CategoryController::class, 'show']);
    });

    // Cart Routes (Session-based, works for both authenticated and guest users)
    Route::prefix('cart')->middleware(['web'])->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('add', [CartController::class, 'add']);
        Route::put('{id}', [CartController::class, 'update']);
        Route::delete('{id}', [CartController::class, 'remove']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // Order Routes
    Route::prefix('orders')->middleware(['web'])->group(function () {
        Route::post('buy-now', [OrderController::class, 'buyNow']);
        Route::post('checkout', [OrderController::class, 'checkout']);
        
        // Protected Order Routes (Authenticated users only)
        Route::middleware('auth:api')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('{id}', [OrderController::class, 'show']);
            Route::post('{id}/cancel', [OrderController::class, 'cancel']);
        });
    });

    // Wishlist Routes (Protected)
    Route::prefix('wishlist')->middleware(['auth:api'])->group(function () {
        Route::get('/', function() {
            return response()->json([
                'success' => true, 
                'message' => 'Wishlist feature coming soon!',
                'data' => []
            ]);
        });
        Route::post('add', function() {
            return response()->json([
                'success' => true, 
                'message' => 'Product added to wishlist! (Feature coming soon)'
            ]);
        });
        Route::delete('{id}', function() {
            return response()->json([
                'success' => true, 
                'message' => 'Product removed from wishlist! (Feature coming soon)'
            ]);
        });
    });

    // Shop Routes (Public - for browsing shops)
    Route::prefix('shops')->group(function () {
        Route::get('/', function() {
            $shops = \App\Models\Shop::where('is_active', true)
                ->with(['admin'])
                ->withCount(['products' => function($query) {
                    $query->where('is_active', true);
                }])
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $shops
            ]);
        });
        
        Route::get('{id}', function($id) {
            $shop = \App\Models\Shop::where('is_active', true)
                ->with(['admin'])
                ->withCount(['products' => function($query) {
                    $query->where('is_active', true);
                }])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $shop
            ]);
        });
    });

    // General App Data Routes
    Route::get('app-data', function() {
        return response()->json([
            'success' => true,
            'data' => [
                'app_name' => 'HerbDash',
                'version' => '1.0.0',
                'api_version' => 'v1',
                'features' => [
                    'guest_checkout' => true,
                    'multi_vendor' => true,
                    'wishlist' => false, // Coming soon
                    'reviews' => false,  // Coming soon
                    'notifications' => false // Coming soon
                ]
            ]
        ]);
    });
});

// Legacy Routes (for backward compatibility without v1 prefix)
Route::prefix('cart')->middleware(['web'])->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('add', [CartController::class, 'add']);
    Route::put('{id}', [CartController::class, 'update']);
    Route::delete('{id}', [CartController::class, 'remove']);
    Route::delete('/', [CartController::class, 'clear']);
    Route::get('count', [CartController::class, 'count']);
});

// Order routes
Route::post('orders/buy-now', [OrderController::class, 'buyNow'])->middleware(['web']);
Route::post('orders/checkout', [OrderController::class, 'checkout'])->middleware(['web']);
Route::post('orders/create-from-cart', [OrderController::class, 'createFromCart'])->middleware(['web']);

// Test route
Route::post('test-endpoint', function() {
    return response()->json(['success' => true, 'message' => 'Test route working']);
});

// Protected Order Routes (Authenticated users only)
Route::middleware('auth:api')->group(function () {
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
