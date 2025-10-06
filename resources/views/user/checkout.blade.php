@extends('user.layout')

@section('title', 'Checkout - Complete Your Order')

@section('content')
<div class="checkout-page">
    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb" class="py-3">
            <ol class="breadcrumb modern-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.cart') }}">Cart</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>
    </div>

    <div class="container pb-5">
        <div class="row">
            <!-- Main Checkout Form -->
            <div class="col-lg-8">
                <div class="checkout-form-container">
                    <div class="checkout-header mb-4">
                        <h2 class="checkout-title">Complete Your Order</h2>
                        <p class="checkout-subtitle">Please fill in your details to complete the purchase</p>
                    </div>

                    <form id="checkoutForm" class="checkout-form">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Customer Information -->
                        <div class="checkout-section mb-4">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-user me-2"></i>Customer Information
                                </h4>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customer_name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               value="{{ $order->customer_name ?? (auth()->user()->name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customer_email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                               value="{{ $order->customer_email ?? (auth()->user()->email ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customer_phone" class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                               value="{{ $order->customer_phone ?? (auth()->user()->phone ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="checkout-section mb-4">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-shipping-fast me-2"></i>Shipping Address
                                </h4>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="shipping_address" class="form-label">Street Address *</label>
                                        <input type="text" class="form-control" id="shipping_address" name="shipping_address[street]" 
                                               placeholder="Enter your street address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="shipping_city" name="shipping_address[city]" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_state" class="form-label">State/Province *</label>
                                        <input type="text" class="form-control" id="shipping_state" name="shipping_address[state]" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_zip" class="form-label">ZIP/Postal Code *</label>
                                        <input type="text" class="form-control" id="shipping_zip" name="shipping_address[zip]" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_country" class="form-label">Country *</label>
                                        <select class="form-select" id="shipping_country" name="shipping_address[country]" required>
                                            <option value="">Select Country</option>
                                            <option value="US">United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="IN" selected>India</option>
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="checkout-section mb-4">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-file-invoice me-2"></i>Billing Address
                                </h4>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="same_as_shipping" checked>
                                    <label class="form-check-label" for="same_as_shipping">
                                        Same as shipping address
                                    </label>
                                </div>
                            </div>
                            <div class="section-content" id="billing_address_section" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="billing_address" class="form-label">Street Address *</label>
                                        <input type="text" class="form-control" id="billing_address" name="billing_address[street]" 
                                               placeholder="Enter billing address">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="billing_city" name="billing_address[city]">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_state" class="form-label">State/Province *</label>
                                        <input type="text" class="form-control" id="billing_state" name="billing_address[state]">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_zip" class="form-label">ZIP/Postal Code *</label>
                                        <input type="text" class="form-control" id="billing_zip" name="billing_address[zip]">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_country" class="form-label">Country *</label>
                                        <select class="form-select" id="billing_country" name="billing_address[country]">
                                            <option value="">Select Country</option>
                                            <option value="US">United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="IN">India</option>
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-section mb-4">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-credit-card me-2"></i>Payment Method
                                </h4>
                            </div>
                            <div class="section-content">
                                <div class="payment-methods">
                                    <div class="payment-option">
                                        <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="credit_card" checked>
                                        <label class="btn btn-outline-primary payment-btn" for="credit_card">
                                            <i class="fas fa-credit-card me-2"></i>Credit Card
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" class="btn-check" name="payment_method" id="debit_card" value="debit_card">
                                        <label class="btn btn-outline-primary payment-btn" for="debit_card">
                                            <i class="fas fa-money-check-alt me-2"></i>Debit Card
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" class="btn-check" name="payment_method" id="paypal" value="paypal">
                                        <label class="btn btn-outline-primary payment-btn" for="paypal">
                                            <i class="fab fa-paypal me-2"></i>PayPal
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" class="btn-check" name="payment_method" id="stripe" value="stripe">
                                        <label class="btn btn-outline-primary payment-btn" for="stripe">
                                            <i class="fab fa-stripe me-2"></i>Stripe
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" class="btn-check" name="payment_method" id="cash_on_delivery" value="cash_on_delivery">
                                        <label class="btn btn-outline-success payment-btn" for="cash_on_delivery">
                                            <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                        </label>
                                    </div>
                                </div>

                                <!-- Credit/Debit Card Form -->
                                <div class="payment-form" id="cardForm" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="cardNumber" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="cardNumber" name="card_number" 
                                                   placeholder="1234 5678 9012 3456" maxlength="19">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cardExpiry" class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" id="cardExpiry" name="card_expiry" 
                                                   placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cardCvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cardCvv" name="card_cvv" 
                                                   placeholder="123" maxlength="4">
                                        </div>
                                        <div class="col-12">
                                            <label for="cardName" class="form-label">Cardholder Name</label>
                                            <input type="text" class="form-control" id="cardName" name="card_name" 
                                                   placeholder="John Doe">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="checkout-section mb-4">
                            <div class="section-header">
                                <h4 class="section-title">
                                    <i class="fas fa-sticky-note me-2"></i>Order Notes (Optional)
                                </h4>
                            </div>
                            <div class="section-content">
                                <textarea class="form-control" id="order_notes" name="order_notes" rows="3" 
                                          placeholder="Any special instructions for your order..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary-container">
                    <div class="order-summary">
                        <h4 class="summary-title">
                            <i class="fas fa-shopping-bag me-2"></i>Order Summary
                        </h4>
                        
                        <!-- Order Items -->
                        <div class="order-items">
                            @foreach($order->items as $item)
                            <div class="order-item">
                                <div class="item-image">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                                    @else
                                        <div class="item-placeholder">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="item-details">
                                    <h6 class="item-name">{{ $item->product->title }}</h6>
                                    <p class="item-shop">{{ $item->product->shop->name }}</p>
                                    <div class="item-price-qty">
                                        <span class="item-qty">Qty: {{ $item->quantity }}</span>
                                        <span class="item-price">${{ number_format($item->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span>Shipping:</span>
                                <span>${{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span>Tax:</span>
                                <span>${{ number_format($order->tax_amount ?? 0, 2) }}</span>
                            </div>
                            <div class="total-row total-final">
                                <span>Total:</span>
                                <span>${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="checkout-actions">
                            <!-- Back to Cart Button -->
                            <a href="{{ route('user.cart.restore-from-checkout') }}" class="btn btn-outline-secondary btn-lg mb-3 w-100">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Cart
                            </a>
                            
                            <!-- Place Order Button -->
                            <button type="button" class="btn btn-success btn-lg w-100 place-order-btn" onclick="processPayment()">
                                <i class="fas fa-lock me-2"></i>
                                <span class="btn-text">Place Order</span>
                                <div class="btn-loader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Processing...
                                </div>
                            </button>
                        </div>

                        <!-- Security Badge -->
                        <div class="security-badge mt-3">
                            <i class="fas fa-shield-alt me-2"></i>
                            <small>Your payment information is secure and encrypted</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Checkout Page Styles */
.checkout-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.modern-breadcrumb {
    background: transparent;
    padding: 0;
}

.modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-weight: bold;
    color: #6c757d;
}

.checkout-form-container {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.checkout-header {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 20px;
}

.checkout-title {
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 5px;
}

.checkout-subtitle {
    color: #636e72;
    margin-bottom: 0;
}

.checkout-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.section-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    color: #2d3436;
    font-size: 16px;
    font-weight: 600;
    margin: 0;
}

.section-content {
    padding: 20px;
}

.form-control, .form-select {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 12px 15px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #8B4513;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.payment-btn {
    width: 100%;
    padding: 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.payment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-check:checked + .payment-btn {
    background-color: #8B4513;
    border-color: #8B4513;
    color: white;
}

.card-payment-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.order-summary-container {
    position: sticky;
    top: 20px;
}

.order-summary {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.summary-title {
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.order-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f3f4;
}

.order-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-placeholder {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 14px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 5px;
    line-height: 1.3;
}

.item-shop {
    font-size: 12px;
    color: #636e72;
    margin-bottom: 8px;
}

.item-price-qty {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.item-qty {
    font-size: 12px;
    color: #636e72;
}

.item-price {
    font-size: 14px;
    font-weight: 600;
    color: #8B4513;
}

.order-totals {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}

.total-final {
    font-size: 18px;
    font-weight: 700;
    color: #2d3436;
    padding-top: 15px;
    border-top: 2px solid #8B4513;
    margin-top: 15px;
}

.place-order-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 8px;
    padding: 15px;
    font-weight: 600;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.place-order-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

.place-order-btn:disabled {
    opacity: 0.7;
    transform: none;
    box-shadow: none;
}

.security-badge {
    text-align: center;
    color: #28a745;
}

/* Responsive Design */
@media (max-width: 768px) {
    .checkout-form-container,
    .order-summary {
        padding: 20px;
    }
    
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .order-summary-container {
        position: static;
        margin-top: 30px;
    }
}
</style>

<script>
// Checkout functionality
document.addEventListener('DOMContentLoaded', function() {
    // Same as shipping address toggle
    const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
    const billingAddressSection = document.getElementById('billing_address_section');
    
    sameAsShippingCheckbox.addEventListener('change', function() {
        if (this.checked) {
            billingAddressSection.style.display = 'none';
            // Clear billing address fields
            billingAddressSection.querySelectorAll('input, select').forEach(field => {
                field.removeAttribute('required');
            });
        } else {
            billingAddressSection.style.display = 'block';
            // Make billing address fields required
            billingAddressSection.querySelectorAll('input, select').forEach(field => {
                if (field.name.includes('billing_address')) {
                    field.setAttribute('required', 'required');
                }
            });
        }
    });

    // Payment method toggle
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const cardForm = document.getElementById('cardForm');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card' || this.value === 'debit_card') {
                cardForm.style.display = 'block';
                // Make card fields required
                cardForm.querySelectorAll('input').forEach(field => {
                    field.setAttribute('required', 'required');
                });
            } else {
                cardForm.style.display = 'none';
                // Remove required from card fields and clear values
                cardForm.querySelectorAll('input').forEach(field => {
                    field.removeAttribute('required');
                    field.value = ''; // Clear the field value
                });
            }
        });
    });

    // Card number formatting
    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            let value = this.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            this.value = formattedValue;
        });
    }

    // Card expiry formatting
    const cardExpiryInput = document.getElementById('card_expiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });
    }

    // CVV formatting
    const cardCvvInput = document.getElementById('card_cvv');
    if (cardCvvInput) {
        cardCvvInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});

// Process payment
function processPayment() {
    const form = document.getElementById('checkoutForm');
    const button = document.querySelector('.place-order-btn');
    const btnText = button.querySelector('.btn-text');
    const btnLoader = button.querySelector('.btn-loader');
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Show loading state
    button.disabled = true;
    btnText.style.display = 'none';
    btnLoader.style.display = 'inline-block';
    
    // Prepare form data
    const formData = new FormData(form);
    
    // Handle billing address same as shipping
    if (document.getElementById('same_as_shipping').checked) {
        formData.set('billing_address[street]', formData.get('shipping_address[street]'));
        formData.set('billing_address[city]', formData.get('shipping_address[city]'));
        formData.set('billing_address[state]', formData.get('shipping_address[state]'));
        formData.set('billing_address[zip]', formData.get('shipping_address[zip]'));
        formData.set('billing_address[country]', formData.get('shipping_address[country]'));
    }
    
    // Convert FormData to JSON
    const data = {};
    const paymentMethod = formData.get('payment_method');
    
    for (let [key, value] of formData.entries()) {
        // Skip card fields if not using card payment
        if (paymentMethod !== 'credit_card' && paymentMethod !== 'debit_card') {
            if (key.startsWith('card_')) {
                continue; // Skip card fields for non-card payments
            }
        }
        
        if (key.includes('[') && key.includes(']')) {
            const matches = key.match(/^([^[]+)\[([^\]]+)\]$/);
            if (matches) {
                const [, mainKey, subKey] = matches;
                if (!data[mainKey]) data[mainKey] = {};
                data[mainKey][subKey] = value;
            }
        } else {
            data[key] = value;
        }
    }
    
    // Send payment request
    fetch('{{ route("user.checkout.process-payment") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message with order number
            const successMessage = `🎉 Order placed successfully! Order #${data.order_number}`;
            showToast(successMessage, 'success');
            
            // Update button to show success state
            const button = document.querySelector('.place-order-btn');
            const btnText = button.querySelector('.btn-text');
            const btnLoader = button.querySelector('.btn-loader');
            
            btnLoader.style.display = 'none';
            btnText.innerHTML = '<i class="fas fa-check me-2"></i>Order Placed Successfully!';
            button.classList.remove('btn-success');
            button.classList.add('btn-success');
            button.style.background = '#28a745';
            
            // Show additional success info
            showOrderSuccessModal(data);
            
            // Redirect after showing success
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 3000);
        } else {
            showToast(data.message || 'Payment failed. Please try again.', 'error');
            resetButton();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Something went wrong. Please try again.', 'error');
        resetButton();
    });
    
    function resetButton() {
        button.disabled = false;
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
    }
}

function showOrderSuccessModal(data) {
    // Create success modal
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.display = 'block';
    modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 60px;"></i>
                    </div>
                    <h4 class="text-success mb-3">Order Placed Successfully!</h4>
                    <p class="mb-3">Your order <strong>#${data.order_number}</strong> has been confirmed.</p>
                    <p class="text-muted mb-4">You will be redirected to the order details page shortly...</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-success" onclick="window.location.href='${data.redirect_url}'">
                            <i class="fas fa-eye me-2"></i>View Order Details
                        </button>
                        <button class="btn btn-outline-secondary" onclick="window.location.href='{{ route('user.home') }}'">
                            <i class="fas fa-home me-2"></i>Continue Shopping
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Auto remove modal after 5 seconds
    setTimeout(() => {
        if (modal.parentNode) {
            modal.remove();
        }
    }, 5000);
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}
</script>
@endsection
