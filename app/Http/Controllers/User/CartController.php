<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $cartTotal = 0;
        $cartCount = 0;

        // Convert cart session data to detailed product information
        foreach ($cart as $productId => $item) {
            $product = Product::with('shop')->find($productId);
            
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'original_price' => $item['original_price'] ?? $product->price,
                    'subtotal' => $item['price'] * $item['quantity']
                ];
                
                $cartTotal += $item['price'] * $item['quantity'];
                $cartCount += $item['quantity'];
            }
        }

        return view('user.cart', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Restore cart from checkout backup
     */
    public function restoreFromCheckout()
    {
        $backupCart = Session::get('checkout_cart_backup');
        $orderIds = Session::get('checkout_order_ids', []);
        
        if ($backupCart) {
            // Restore the cart
            Session::put('cart', $backupCart);
            
            // Delete the pending orders since user went back
            if (!empty($orderIds)) {
                Order::whereIn('id', $orderIds)
                     ->where('payment_status', 'pending')
                     ->delete();
            }
            
            // Clear backup sessions
            Session::forget('checkout_cart_backup');
            Session::forget('checkout_order_ids');
            
            return redirect()->route('user.cart')
                           ->with('success', 'Cart restored successfully!');
        }
        
        return redirect()->route('user.cart')
                       ->with('info', 'No cart to restore.');
    }

    /**
     * Clear the entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->route('user.cart')
                        ->with('success', 'Cart cleared successfully!');
    }

    /**
     * Remove a specific item from cart
     */
    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            
            return redirect()->route('user.cart')
                            ->with('success', 'Product removed from cart!');
        }
        
        return redirect()->route('user.cart')
                        ->with('error', 'Product not found in cart!');
    }

    /**
     * Update quantity of a cart item
     */
    public function updateQuantity(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            
            return redirect()->route('user.cart')
                            ->with('success', 'Cart updated successfully!');
        }
        
        return redirect()->route('user.cart')
                        ->with('error', 'Product not found in cart!');
    }

    /**
     * Create orders from cart and redirect to checkout
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('user.cart')
                            ->with('error', 'Your cart is empty.');
        }

        \Log::info('Cart checkout started', [
            'cart_items' => count($cart),
            'user_id' => Auth::id()
        ]);

        // Check if user is authenticated, if not redirect to login
        if (!Auth::check()) {
            return redirect()->route('user.login')
                            ->with('error', 'Please login to proceed with checkout.');
        }

        try {
            // Group cart items by shop
            $shopGroups = [];
            foreach ($cart as $productId => $item) {
                $product = Product::with('shop')->find($productId);
                if ($product && $product->shop) {
                    $shopGroups[$product->shop_id][] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ];
                }
            }

            if (empty($shopGroups)) {
                return redirect()->route('user.cart')
                                ->with('error', 'No valid products found in cart!');
            }

            $orderIds = [];

            // Create separate orders for each shop
            foreach ($shopGroups as $shopId => $items) {
                $totalAmount = 0;
                
                // Calculate total for this shop
                foreach ($items as $item) {
                    $totalAmount += $item['price'] * $item['quantity'];
                }

                // Get user information
                $user = Auth::user();
                
                // Create order
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'user_id' => $user->id,
                    'shop_id' => $shopId,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => null,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone ?? '',
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '',
                    'customer_address' => $user->address ?? '',
                    'shipping_address' => json_encode([
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone ?? '',
                        'address' => $user->address ?? 'Address to be provided during checkout',
                        'city' => '',
                        'state' => '',
                        'zip' => '',
                        'country' => 'India'
                    ]),
                ]);

                // Create order items
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->title,
                        'product_title' => $item['product']->title,
                        'product_sku' => $item['product']->sku ?? '',
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity']
                    ]);
                }

                $orderIds[] = $order->id;
            }

            // Store cart in session for potential restoration
            Session::put('checkout_cart_backup', $cart);
            Session::put('checkout_order_ids', $orderIds);

            \Log::info('Orders created successfully', [
                'order_ids' => $orderIds,
                'user_id' => Auth::id()
            ]);

            // Redirect to checkout
            if (count($orderIds) === 1) {
                return redirect()->route('user.checkout', $orderIds[0])
                                ->with('success', 'Order created successfully! Please complete your payment.');
            } else {
                return redirect()->route('user.checkout.multiple', ['orders' => implode(',', $orderIds)])
                                ->with('success', 'Orders created successfully! Please complete your payment.');
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Cart checkout failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cart' => $cart,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('user.cart')
                            ->with('error', 'Failed to create orders: ' . $e->getMessage());
        }
    }

    /**
     * Add product to cart (AJAX endpoint)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10'
        ]);

        $product = Product::with('shop')->findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Check if product is active and available
        if (!$product->is_active || !$product->shop->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ]);
        }

        // Check stock
        if ($product->stock_status !== 'in_stock' || $product->quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        // Get current cart
        $cart = Session::get('cart', []);

        // Determine price (selling price if available, otherwise regular price)
        $price = $product->selling_price && $product->selling_price < $product->price 
                ? $product->selling_price 
                : $product->price;

        // Add or update product in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => $price,
                'original_price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'shop_name' => $product->shop->name
            ];
        }

        // Update session
        Session::put('cart', $cart);

        // Calculate cart count
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount
        ]);
    }
}
