<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout page for single order
     */
    public function show($orderId)
    {
        try {
            $order = Order::with(['items.product', 'shop', 'user'])
                          ->findOrFail($orderId);

            // Check if user has access to this order
            if (Auth::check() && $order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to order');
            }

            return view('user.checkout', compact('order'));

        } catch (\Exception $e) {
            \Log::error('Checkout page error: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('user.cart')
                           ->with('error', 'Unable to load checkout page: ' . $e->getMessage());
        }
    }

    /**
     * Show checkout page for multiple orders
     */
    public function showMultiple(Request $request)
    {
        try {
            $orderIds = explode(',', $request->get('orders', ''));
            
            $orders = Order::with(['items.product', 'shop', 'user'])
                          ->whereIn('id', $orderIds)
                          ->get();

            if ($orders->isEmpty()) {
                return redirect()->route('user.home')
                               ->with('error', 'No orders found');
            }

            // Check if user has access to these orders
            if (Auth::check()) {
                foreach ($orders as $order) {
                    if ($order->user_id !== Auth::id()) {
                        abort(403, 'Unauthorized access to orders');
                    }
                }
            }

            return view('user.checkout-multiple', compact('orders'));

        } catch (\Exception $e) {
            return redirect()->route('user.home')
                           ->with('error', 'Orders not found or access denied');
        }
    }

    /**
     * Process payment and complete order
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,stripe,cash_on_delivery',
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20'
        ]);

        try {
            $order = Order::findOrFail($request->order_id);

            // Check if user has access to this order
            if (Auth::check() && $order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to order'
                ], 403);
            }

            // Process payment based on method
            $paymentStatus = 'pending';
            $paymentResponse = null;

            switch ($request->payment_method) {
                case 'stripe':
                case 'credit_card':
                case 'debit_card':
                    $paymentResponse = $this->processCardPayment($request, $order);
                    $paymentStatus = $paymentResponse['success'] ? 'paid' : 'failed';
                    break;
                
                case 'paypal':
                    $paymentResponse = $this->processPayPalPayment($request, $order);
                    $paymentStatus = $paymentResponse['success'] ? 'paid' : 'failed';
                    break;
                
                case 'cash_on_delivery':
                    $paymentStatus = 'pending';
                    $paymentResponse = ['success' => true, 'message' => 'Cash on delivery selected'];
                    break;
            }

            if (!$paymentResponse['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $paymentResponse['message'] ?? 'Payment processing failed'
                ], 400);
            }

            // Update order with payment and customer information
            $order->update([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'status' => $paymentStatus === 'paid' ? 'processing' : 'pending',
                'shipping_address' => json_encode($request->shipping_address),
                'billing_address' => json_encode($request->billing_address),
                'order_notes' => $request->order_notes ?? null,
                'payment_reference' => $paymentResponse['reference'] ?? null
            ]);

            // Clear any session data including cart backup
            Session::forget('current_order_id');
            Session::forget('cart');
            Session::forget('checkout_cart_backup');
            Session::forget('checkout_order_ids');

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect_url' => route('user.checkout.success', $order->id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process card payment (Stripe/Credit/Debit)
     */
    private function processCardPayment(Request $request, Order $order)
    {
        try {
            // In a real implementation, you would integrate with Stripe API
            // For demo purposes, we'll simulate payment processing
            
            // Validate card details
            if (!$request->card_number || !$request->card_expiry || !$request->card_cvv || !$request->card_name) {
                return [
                    'success' => false,
                    'message' => 'Please provide all card details'
                ];
            }

            // Simulate payment processing delay
            sleep(1);

            // Simulate payment success (90% success rate for demo)
            $success = rand(1, 10) <= 9;

            if ($success) {
                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'reference' => 'TXN_' . strtoupper(Str::random(10))
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Payment declined. Please check your card details and try again.'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Payment processing error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process PayPal payment
     */
    private function processPayPalPayment(Request $request, Order $order)
    {
        try {
            // In a real implementation, you would integrate with PayPal API
            // For demo purposes, we'll simulate payment processing
            
            // Simulate payment processing delay
            sleep(1);

            // Simulate payment success (95% success rate for demo)
            $success = rand(1, 20) <= 19;

            if ($success) {
                return [
                    'success' => true,
                    'message' => 'PayPal payment processed successfully',
                    'reference' => 'PP_' . strtoupper(Str::random(12))
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'PayPal payment failed. Please try again.'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'PayPal processing error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        try {
            $order = Order::with(['items.product', 'shop'])
                          ->findOrFail($orderId);

            // Check if user has access to this order
            if (Auth::check() && $order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to order');
            }

            return view('user.order-success', compact('order'));

        } catch (\Exception $e) {
            return redirect()->route('user.home')
                           ->with('error', 'Order not found');
        }
    }
}
