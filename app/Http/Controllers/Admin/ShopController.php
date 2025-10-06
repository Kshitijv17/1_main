<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of shops
     */
    public function index(Request $request)
    {
        $query = Shop::with(['admin', 'products', 'orders']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('admin', function($adminQuery) use ($search) {
                      $adminQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $shops = $query->paginate(15)->withQueryString();

        // Calculate statistics
        $stats = [
            'total_shops' => Shop::count(),
            'active_shops' => Shop::where('is_active', true)->count(),
            'inactive_shops' => Shop::where('is_active', false)->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        return view('admin.shops.index', compact('shops', 'stats'));
    }

    /**
     * Show the form for creating a new shop
     */
    public function create()
    {
        // Get available admins (users with admin role who don't have a shop yet)
        $availableAdmins = User::where('role', 'admin')
                              ->whereDoesntHave('shop')
                              ->get();

        return view('admin.shops.create', compact('availableAdmins'));
    }

    /**
     * Store a newly created shop
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'admin_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:shops,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'website' => 'nullable|url',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'banner']);
        $data['slug'] = Shop::generateSlug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('shops/banners', 'public');
        }

        Shop::create($data);

        return redirect()->route('admin.shops.index')
                        ->with('success', 'Shop created successfully!');
    }

    /**
     * Display the specified shop
     */
    public function show(Shop $shop)
    {
        $shop->load(['admin', 'products', 'orders']);
        
        // Get shop statistics
        $stats = [
            'total_products' => $shop->products()->count(),
            'active_products' => $shop->products()->where('is_active', true)->count(),
            'total_orders' => $shop->orders()->count(),
            'pending_orders' => $shop->orders()->where('status', 'pending')->count(),
            'processing_orders' => $shop->orders()->where('status', 'processing')->count(),
            'completed_orders' => $shop->orders()->where('status', 'delivered')->count(),
            'total_revenue' => $shop->orders()->where('payment_status', 'paid')->sum('total_amount'),
            'pending_revenue' => $shop->orders()->where('payment_status', 'pending')->sum('total_amount'),
        ];

        // Recent orders
        $recentOrders = $shop->orders()->with('items.product')
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();

        // Top products
        $topProducts = $shop->products()
                           ->withCount('orderItems')
                           ->orderBy('order_items_count', 'desc')
                           ->limit(5)
                           ->get();

        return view('admin.shops.show', compact('shop', 'stats', 'recentOrders', 'topProducts'));
    }

    /**
     * Show the form for editing the specified shop
     */
    public function edit(Shop $shop)
    {
        // Get available admins (current admin + users with admin role who don't have a shop)
        $availableAdmins = User::where('role', 'admin')
                              ->where(function($query) use ($shop) {
                                  $query->whereDoesntHave('shop')
                                        ->orWhere('id', $shop->admin_id);
                              })
                              ->get();

        return view('admin.shops.edit', compact('shop', 'availableAdmins'));
    }

    /**
     * Update the specified shop
     */
    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'admin_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:shops,email,' . $shop->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'website' => 'nullable|url',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'banner']);
        $data['is_active'] = $request->has('is_active');

        // Update slug if name changed
        if ($shop->name !== $request->name) {
            $data['slug'] = Shop::generateSlug($request->name);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($shop->logo) {
                Storage::disk('public')->delete($shop->logo);
            }
            $data['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($shop->banner) {
                Storage::disk('public')->delete($shop->banner);
            }
            $data['banner'] = $request->file('banner')->store('shops/banners', 'public');
        }

        $shop->update($data);

        return redirect()->route('admin.shops.index')
                        ->with('success', 'Shop updated successfully!');
    }

    /**
     * Remove the specified shop
     */
    public function destroy(Shop $shop)
    {
        // Check if shop has orders
        if ($shop->orders()->count() > 0) {
            return redirect()->route('admin.shops.index')
                           ->with('error', 'Cannot delete shop with existing orders. Please archive it instead.');
        }

        // Delete associated files
        if ($shop->logo) {
            Storage::disk('public')->delete($shop->logo);
        }
        if ($shop->banner) {
            Storage::disk('public')->delete($shop->banner);
        }

        $shop->delete();

        return redirect()->route('admin.shops.index')
                        ->with('success', 'Shop deleted successfully!');
    }

    /**
     * Toggle shop status
     */
    public function toggleStatus(Shop $shop)
    {
        $shop->update(['is_active' => !$shop->is_active]);

        $status = $shop->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "Shop {$status} successfully!",
            'status' => $shop->is_active
        ]);
    }

    /**
     * Bulk actions for shops
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'shop_ids' => 'required|array',
            'shop_ids.*' => 'exists:shops,id'
        ]);

        $shops = Shop::whereIn('id', $request->shop_ids);
        $count = $shops->count();

        switch ($request->action) {
            case 'activate':
                $shops->update(['is_active' => true]);
                $message = "{$count} shops activated successfully!";
                break;
            
            case 'deactivate':
                $shops->update(['is_active' => false]);
                $message = "{$count} shops deactivated successfully!";
                break;
            
            case 'delete':
                // Check if any shop has orders
                $shopsWithOrders = $shops->whereHas('orders')->count();
                if ($shopsWithOrders > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete shops with existing orders.'
                    ]);
                }
                
                $shops->delete();
                $message = "{$count} shops deleted successfully!";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Export shops data
     */
    public function export(Request $request)
    {
        $query = Shop::with(['admin']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $shops = $query->get();

        $csvData = [];
        $csvData[] = ['ID', 'Name', 'Email', 'Phone', 'Admin', 'Status', 'Commission Rate', 'Created At'];

        foreach ($shops as $shop) {
            $csvData[] = [
                $shop->id,
                $shop->name,
                $shop->email,
                $shop->phone,
                $shop->admin->name ?? 'N/A',
                $shop->is_active ? 'Active' : 'Inactive',
                $shop->commission_rate . '%',
                $shop->created_at->format('Y-m-d H:i:s')
            ];
        }

        $filename = 'shops_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
        exit;
    }
}
