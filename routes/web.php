<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Enums\UserRole;
use App\Http\Middleware\ProtectUserDashboard;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Vendor\AuthController as VendorAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\PermissionManagementController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\CmsController as AdminCmsController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;

//
// 🏠 Welcome Page
//
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

//
// User Authentication Routes
//
Route::get('/login', [UserAuthController::class, 'loginForm'])->name('user.login');
Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');
Route::get('/register', [UserAuthController::class, 'registerForm'])->name('user.register');
Route::post('/register', [UserAuthController::class, 'register'])->name('user.register.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// Generic Login Route (for authentication middleware redirects)
Route::get('/login-redirect', function () {
    // Check if the request is coming from a specific admin area
    $referer = request()->headers->get('referer');
    
    if (str_contains($referer, '/admin')) {
        return redirect()->route('admin.login');
    } elseif (str_contains($referer, '/vendor')) {
        return redirect()->route('vendor.login');
    } else {
        // Default to user login for general access
        return redirect()->route('user.login');
    }
})->name('login');

//
//  Guest Routes
//
Route::get('/guest-login', function () {
    $names = ['CaptainZiggy', 'BubbleNinja', 'ToonBoomer', 'FluffyBolt', 'ZapsterZoom', 'MangoMutt', 'WackyWhirl'];
    $passwords = ['fluffyDragon99', 'splatZap42', 'toonTwist88', 'zapBoom33', 'giggleSnout77', 'bubblePop66'];

    $name = $names[array_rand($names)];
    $password = $passwords[array_rand($passwords)];
    $email = strtolower($name) . '@guest.local';

    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => bcrypt($password),
            'role' => UserRole::GUEST,
            'expires_at' => now()->addDays(7),
            'is_guest' => true,
        ]
    );

    session([
        'guest_name' => $name,
        'guest_email' => $email,
        'guest_password' => $password,
    ]);

    return redirect()->route('guest.show');
})->name('guest.login');

Route::get('/guest-show', function () {
    return view('guest.show', [
        'name' => session('guest_name'),
        'email' => session('guest_email'),
        'password' => session('guest_password'),
    ]);
})->name('guest.show');

Route::post('/guest-enter', function () {
    $email = session('guest_email');
    $user = User::where('email', $email)->first();
    Auth::guard('web')->login($user);
    return redirect()->route('user.home');
})->name('guest.enter');



//
// Admin Authentication Routes
//
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminAuthController::class, 'registerForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//
// Admin Routes (Marketplace Admin with full access)
//
Route::prefix('admin')->group(function () {
    // Dashboard (Protected by auth and admin middleware)
    Route::middleware(['auth:admin', 'role:admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // Bulk Product Upload
        Route::get('products/bulk-upload', [AdminProductController::class, 'bulkUploadForm'])->name('admin.products.bulk-upload-form');
        Route::post('products/bulk-upload', [AdminProductController::class, 'bulkUpload'])->name('admin.products.bulk-upload');
        Route::get('products/csv-template', [AdminProductController::class, 'downloadCsvTemplate'])->name('admin.products.csv-template');

        // Product CRUD
        Route::resource('products', AdminProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
        Route::delete('products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('admin.products.delete-image');

        // Category CRUD
        Route::resource('categories', AdminCategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'show' => 'admin.categories.show',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);
        
        // Category Ordering
        Route::get('categories/order', [AdminCategoryController::class, 'order'])->name('admin.categories.order');
        Route::post('categories/update-order', [AdminCategoryController::class, 'updateOrder'])->name('admin.categories.update-order');

        // Order Management
        Route::resource('orders', AdminOrderController::class)->names([
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
        ])->only(['index', 'show']);
        
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::put('orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment-status');
        Route::post('orders/bulk-update', [AdminOrderController::class, 'bulkUpdate'])->name('admin.orders.bulk-update');
        Route::get('orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
        Route::get('orders/analytics', [AdminOrderController::class, 'analytics'])->name('admin.orders.analytics');

        // Shop Management
        Route::resource('shops', AdminShopController::class)->names([
            'index' => 'admin.shops.index',
            'create' => 'admin.shops.create',
            'store' => 'admin.shops.store',
            'show' => 'admin.shops.show',
            'edit' => 'admin.shops.edit',
            'update' => 'admin.shops.update',
            'destroy' => 'admin.shops.destroy',
        ]);
        
        Route::put('shops/{shop}/toggle-status', [AdminShopController::class, 'toggleStatus'])->name('admin.shops.toggle-status');
        Route::post('shops/bulk-action', [AdminShopController::class, 'bulkAction'])->name('admin.shops.bulk-action');
        Route::get('shops/export', [AdminShopController::class, 'export'])->name('admin.shops.export');

        // CMS Content Management (TODO: Create CmsController)
        // Route::resource('cms', AdminCmsController::class)->names([
        //     'index' => 'admin.cms.index',
        //     'create' => 'admin.cms.create',
        //     'store' => 'admin.cms.store',
        //     'show' => 'admin.cms.show',
        //     'edit' => 'admin.cms.edit',
        //     'update' => 'admin.cms.update',
        //     'destroy' => 'admin.cms.destroy',
        // ]);
        // 
        // // CMS Additional Routes
        // Route::post('cms/bulk-action', [AdminCmsController::class, 'bulkAction'])->name('admin.cms.bulk-action');
        // Route::get('cms/{cms}/duplicate', [AdminCmsController::class, 'duplicate'])->name('admin.cms.duplicate');

        // Admin Management
        Route::resource('admins', AdminManagementController::class)->names([
            'index' => 'admin.admins.index',
            'create' => 'admin.admins.create',
            'store' => 'admin.admins.store',
            'show' => 'admin.admins.show',
            'edit' => 'admin.admins.edit',
            'update' => 'admin.admins.update',
            'destroy' => 'admin.admins.destroy',
        ]);

        // Permission Management
        Route::resource('permissions', PermissionManagementController::class)->names([
            'index' => 'admin.permissions.index',
            'create' => 'admin.permissions.create',
            'store' => 'admin.permissions.store',
            'show' => 'admin.permissions.show',
            'edit' => 'admin.permissions.edit',
            'update' => 'admin.permissions.update',
            'destroy' => 'admin.permissions.destroy',
        ]);
        
        // Permission User Management
        Route::get('permissions/users/{user}', [PermissionManagementController::class, 'showUser'])->name('admin.permissions.user.show');
        Route::put('permissions/users/{user}', [PermissionManagementController::class, 'updateUser'])->name('admin.permissions.user.update');
        Route::post('permissions/bulk-assign', [PermissionManagementController::class, 'bulkAssign'])->name('admin.permissions.bulk-assign');
        Route::post('permissions/bulk-update', [PermissionManagementController::class, 'bulkUpdate'])->name('admin.permissions.bulk-update');
        Route::post('permissions/remove-from-user', [PermissionManagementController::class, 'removeFromUser'])->name('admin.permissions.remove-from-user');
    });
});

//
// Vendor Authentication Routes
//
Route::get('/vendor/login', [VendorAuthController::class, 'loginForm'])->name('vendor.login');
Route::post('/vendor/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
Route::get('/vendor/register', [VendorAuthController::class, 'registerForm'])->name('vendor.register');
Route::post('/vendor/register', [VendorAuthController::class, 'register'])->name('vendor.register.submit');
Route::post('/vendor/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');

//
//  🏪 VENDOR PANEL (Vendor/Shop Owner)
//
Route::prefix('vendor')->group(function () {
    // Protected Vendor Routes
    Route::middleware(['auth:vendor', 'role:vendor'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Vendor\VendorController::class, 'dashboard'])->name('vendor.dashboard');
        
        // Shop Management
        Route::get('/shop/create', [\App\Http\Controllers\Vendor\VendorController::class, 'createShop'])->name('vendor.shop.create');
        Route::post('/shop', [\App\Http\Controllers\Vendor\VendorController::class, 'storeShop'])->name('vendor.shop.store');
        Route::get('/shop/edit', [\App\Http\Controllers\Vendor\VendorController::class, 'editShop'])->name('vendor.shop.edit');
        Route::put('/shop', [\App\Http\Controllers\Vendor\VendorController::class, 'updateShop'])->name('vendor.shop.update');
        
        // Product Management (All admin product functionality moved here)
        Route::get('products/bulk-upload', [VendorProductController::class, 'bulkUploadForm'])->name('vendor.products.bulk-upload-form');
        Route::post('products/bulk-upload', [VendorProductController::class, 'bulkUpload'])->name('vendor.products.bulk-upload');
        Route::get('products/csv-template', [VendorProductController::class, 'downloadCsvTemplate'])->name('vendor.products.csv-template');
        
        Route::resource('products', \App\Http\Controllers\Vendor\ProductController::class)->names([
            'index' => 'vendor.products.index',
            'create' => 'vendor.products.create',
            'store' => 'vendor.products.store',
            'show' => 'vendor.products.show',
            'edit' => 'vendor.products.edit',
            'update' => 'vendor.products.update',
            'destroy' => 'vendor.products.destroy',
        ]);
        Route::delete('products/images/{image}', [VendorProductController::class, 'deleteImage'])->name('vendor.products.delete-image');
        Route::put('products/{product}/toggle-status', [\App\Http\Controllers\Vendor\ProductController::class, 'toggleStatus'])->name('vendor.products.toggle-status');
        
        
        // Order Management
        Route::resource('orders', \App\Http\Controllers\Vendor\OrderController::class)->names([
            'index' => 'vendor.orders.index',
            'show' => 'vendor.orders.show',
            'edit' => 'vendor.orders.edit',
            'update' => 'vendor.orders.update',
            'destroy' => 'vendor.orders.destroy',
        ])->except(['create', 'store']);
        
        // Order AJAX Routes
        Route::post('orders/{order}/status', [\App\Http\Controllers\Vendor\OrderController::class, 'updateStatus'])->name('vendor.orders.update-status');
        Route::post('orders/{order}/payment-status', [\App\Http\Controllers\Vendor\OrderController::class, 'updatePaymentStatus'])->name('vendor.orders.update-payment-status');
        Route::get('orders/export', [\App\Http\Controllers\Vendor\OrderController::class, 'export'])->name('vendor.orders.export');
    });
});

// User/Public Routes
Route::name('user.')->group(function () {
    // Homepage and product browsing
    Route::get('/', [\App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
    Route::get('/category/{category}', [\App\Http\Controllers\User\HomeController::class, 'category'])->name('category');
    Route::get('/shop/{shop}', [\App\Http\Controllers\User\HomeController::class, 'shop'])->name('shop');
    
    // Product pages
    Route::get('/products', [\App\Http\Controllers\User\ProductController::class, 'index'])->name('products');
    Route::get('/product/{product}', [\App\Http\Controllers\User\ProductController::class, 'show'])->name('product.show');
    Route::get('/search', [\App\Http\Controllers\User\ProductController::class, 'search'])->name('product.search');
    
    // Product reviews (public access)
    Route::get('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'getProductReviews'])->name('product.reviews');
    
    // Cart pages
    Route::get('/cart', [\App\Http\Controllers\User\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [\App\Http\Controllers\User\CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/clear', [\App\Http\Controllers\User\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/remove/{product}', [\App\Http\Controllers\User\CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update-quantity/{product}', [\App\Http\Controllers\User\CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::post('/cart/checkout', [\App\Http\Controllers\User\CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/restore-from-checkout', [\App\Http\Controllers\User\CartController::class, 'restoreFromCheckout'])->name('cart.restore-from-checkout');
    
    // Checkout pages
    Route::get('/checkout/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'show'])->name('checkout');
    Route::get('/checkout-multiple', [\App\Http\Controllers\User\CheckoutController::class, 'showMultiple'])->name('checkout.multiple');
    Route::post('/checkout/process-payment', [\App\Http\Controllers\User\CheckoutController::class, 'processPayment'])->name('checkout.process-payment');
    Route::get('/order-success/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'success'])->name('checkout.success');
    
    // AJAX Search for offcanvas
    Route::get('/ajax-search', [\App\Http\Controllers\User\HomeController::class, 'ajaxSearch'])->name('ajax.search');
    
    // Information Pages
    Route::get('/about-us', [\App\Http\Controllers\User\PageController::class, 'aboutUs'])->name('about-us');
    Route::get('/privacy-policy', [\App\Http\Controllers\User\PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms-conditions', [\App\Http\Controllers\User\PageController::class, 'termsConditions'])->name('terms-conditions');
    Route::get('/shipping-policy', [\App\Http\Controllers\User\PageController::class, 'shippingPolicy'])->name('shipping-policy');
    Route::get('/return-policy', [\App\Http\Controllers\User\PageController::class, 'returnPolicy'])->name('return-policy');
    Route::get('/refund-and-cancellation', [\App\Http\Controllers\User\PageController::class, 'refundCancellation'])->name('refund-cancellation');
    
    // Buy Now functionality (no auth required for guest purchases)
    Route::get('/product/{product}/buy-now', [\App\Http\Controllers\User\OrderController::class, 'buyNow'])->name('buy-now');
    Route::post('/product/{product}/buy-now', [\App\Http\Controllers\User\OrderController::class, 'processBuyNow'])->name('process-buy-now');
    
    // Order pages
    Route::get('/order/{order}/success', [\App\Http\Controllers\User\OrderController::class, 'success'])->name('order.success');
    Route::get('/order/{order}/details', [\App\Http\Controllers\User\OrderController::class, 'show'])->name('order.details');
    
    // User Profile and Account Management (Protected Routes)
    Route::middleware('auth:web')->group(function () {
        // Profile Management
        Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [\App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('password.update');
        
        // My Account and Orders
        Route::get('/my-account', [\App\Http\Controllers\User\AccountController::class, 'index'])->name('my-account');
        Route::get('/my-orders', [\App\Http\Controllers\User\AccountController::class, 'orders'])->name('my-orders');
        
        // Order Management
        Route::get('/orders', [\App\Http\Controllers\User\OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [\App\Http\Controllers\User\OrderController::class, 'show'])->name('orders.show');
        
        // Wishlist Management
        Route::get('/wishlist', [\App\Http\Controllers\User\WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist', [\App\Http\Controllers\User\WishlistController::class, 'store'])->name('wishlist.add');
        Route::delete('/wishlist', [\App\Http\Controllers\User\WishlistController::class, 'destroy'])->name('wishlist.remove');
        Route::post('/wishlist/toggle', [\App\Http\Controllers\User\WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::get('/wishlist/count', [\App\Http\Controllers\User\WishlistController::class, 'count'])->name('wishlist.count');
        
        // Address Management// User Addresses (TODO: Create AddressController)
        Route::get('/addresses', function () { return 'User Addresses Page'; })->name('addresses');
        // Route::get('/addresses', [\App\Http\Controllers\User\AddressController::class, 'index'])->name('addresses');       // Route::post('/addresses', [\App\Http\Controllers\User\AddressController::class, 'store'])->name('addresses.store');
        // Route::put('/addresses/{address}', [\App\Http\Controllers\User\AddressController::class, 'update'])->name('addresses.update');
        // Route::delete('/addresses/{address}', [\App\Http\Controllers\User\AddressController::class, 'destroy'])->name('addresses.destroy');
        
        // Reviews
        Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');
        Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('/reviews/{review}/helpful', [\App\Http\Controllers\ReviewController::class, 'toggleHelpful'])->name('reviews.helpful');
        
        // User Support (TODO: Create SupportController)
        // Route::get('/support', [\App\Http\Controllers\User\SupportController::class, 'index'])->name('support');
        // Route::post('/support', [\App\Http\Controllers\User\SupportController::class, 'store'])->name('support.store');
    });
});