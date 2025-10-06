<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Get or create a guest user for orders
     */
    private function getOrCreateGuestUser()
    {
        $sessionId = session()->getId();
        
        // Check if guest user already exists for this session
        $user = User::where('guest_session_id', $sessionId)
                   ->where('is_guest', true)
                   ->first();

        if (!$user) {
            // Create new guest user
            $user = User::create([
                'name' => 'Guest User',
                'email' => 'guest_' . time() . '@temp.com',
                'password' => Hash::make('guest_password'),
                'role' => 'guest',
                'is_guest' => true,
                'guest_session_id' => $sessionId
            ]);
        }

        return $user;
    }
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        try {
            // Get or create user (authenticated or guest)
            $user = Auth::user();
            if (!$user) {
                $user = $this->getOrCreateGuestUser();
            }
            
            $userId = $user->id;
            $userName = $user->name;
            $userEmail = $user->email;
            $userPhone = $user->phone ?? null;

            // Create a new order
            $order = new Order();
            $order->user_id = $userId; // Can be null for guests
            $order->shop_id = $product->shop_id; // Associate order with the product's shop
            $finalPrice = $product->selling_price ?? $product->price;
            $order->total_amount = $finalPrice * $quantity;
            $order->status = 'pending'; // Or 'completed' if payment is immediate
            $order->payment_status = 'pending';
            $order->user_name = $userName;
            $order->user_email = $userEmail;
            $order->user_phone = $userPhone;
            $order->shipping_address = json_encode(['address' => 'To be provided', 'city' => '', 'state' => '', 'zip' => '']);
            $order->billing_address = json_encode(['address' => 'To be provided', 'city' => '', 'state' => '', 'zip' => '']);
            $order->save();

            // Add the product as an order item
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->product_title = $product->title;
            $orderItem->product_name = $product->title; // Same as title for consistency
            $orderItem->product_sku = $product->sku;
            $orderItem->quantity = $quantity;
            $orderItem->unit_price = $finalPrice;
            $orderItem->total_price = $finalPrice * $quantity;
            $orderItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => $order->load('items'),
                'checkout_url' => route('user.checkout', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to place order', 'error' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        // This method would handle a full cart checkout process
        // For now, let's keep it simple and assume buyNow handles direct purchases.
        return response()->json(['message' => 'Checkout functionality to be implemented']);
    }

    public function createFromCart(Request $request)
    {
        // Simple test first
        return response()->json([
            'success' => true,
            'message' => 'createFromCart endpoint is working!',
            'cart' => Session::get('cart', []),
            'session_id' => session()->getId(),
            'user' => Auth::user() ? Auth::user()->toArray() : null
        ]);
    }

    public function index()
    {
        // Display user's orders
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $orders = Order::where('user_id', Auth::id())->with('items.product')->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        // Display a specific order
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $order = Order::where('user_id', Auth::id())->with('items.product')->findOrFail($id);
        return response()->json($order);
    }

    public function cancel($id)
    {
        // Cancel an order
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        if ($order->status === 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return response()->json(['message' => 'Order cancelled successfully']);
        }
        return response()->json(['message' => 'Order cannot be cancelled'], 400);
    }
}
