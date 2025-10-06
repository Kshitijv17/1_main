<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\UserRole;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get marketplace-wide statistics
        $stats = [
            'total_users' => User::where('role', UserRole::USER)->count(),
            'total_vendors' => User::where('role', UserRole::VENDOR)->count(),
            'total_shops' => Shop::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Get recent orders (last 10)
        $recent_orders = Order::with(['user', 'shop'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get recent users (last 10)
        $recent_users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get recent vendors (last 10)
        $recent_vendors = User::where('role', 'vendor')
            ->with('shop')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get top performing shops
        $top_shops = Shop::withCount('orders')
            ->with('vendor')
            ->orderBy('orders_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'recent_users',
            'recent_vendors',
            'top_shops'
        ));
    }
}
