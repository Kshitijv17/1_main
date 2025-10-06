@extends('user.layout')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
            <li class="breadcrumb-item active">Shopping Cart</li>
        </ol>
    </nav>

    <!-- Checkout Backup Notification -->
    @if(session('checkout_cart_backup'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Incomplete Checkout Detected:</strong> You have items from a previous checkout attempt. 
            <a href="{{ route('user.cart.restore-from-checkout') }}" class="alert-link">Click here to restore them</a> or continue shopping.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cart Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
                @if(count($cartItems) > 0)
                    <a href="{{ route('user.cart.clear') }}" class="btn btn-outline-danger" 
                       onclick="return confirm('Are you sure you want to clear your cart?')">
                        <i class="fas fa-trash me-1"></i>Clear Cart
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Items ({{ $cartCount }} items)</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                            <div class="cart-item border-bottom p-4">
                                <div class="row align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-md-2">
                                        <div class="product-image-container">
                                            @if($item['product']->image)
                                                <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                                     class="img-fluid rounded cart-product-image" 
                                                     alt="{{ $item['product']->title }}">
                                            @else
                                                <div class="no-image-placeholder">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-4">
                                        <h6 class="mb-1">
                                            <a href="{{ route('user.product.show', $item['product']) }}" 
                                               class="text-decoration-none">
                                                {{ $item['product']->title }}
                                            </a>
                                        </h6>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-store me-1"></i>{{ $item['product']->shop->name }}
                                        </p>
                                        @if($item['product']->category)
                                            <small class="text-muted">{{ $item['product']->category->title }}</small>
                                        @endif
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-2">
                                        <div class="price-section">
                                            <span class="fw-bold text-success">${{ number_format($item['price'], 2) }}</span>
                                            @if($item['original_price'] > $item['price'])
                                                <br><small class="text-muted text-decoration-line-through">
                                                    ${{ number_format($item['original_price'], 2) }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="col-md-2">
                                        <form action="{{ route('user.cart.update-quantity', $item['product']->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm">
                                                <button type="button" class="btn btn-outline-secondary" 
                                                        onclick="decreaseQuantity(this)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1" max="10" 
                                                       class="form-control text-center quantity-input"
                                                       onchange="this.form.submit()">
                                                <button type="button" class="btn btn-outline-secondary" 
                                                        onclick="increaseQuantity(this)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Subtotal & Remove -->
                                    <div class="col-md-2">
                                        <div class="text-end">
                                            <div class="fw-bold mb-2">${{ number_format($item['subtotal'], 2) }}</div>
                                            <a href="{{ route('user.cart.remove', $item['product']->id) }}" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Remove this item from cart?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="mt-3">
                    <a href="{{ route('user.home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal ({{ $cartCount }} items):</span>
                            <span class="fw-bold">${{ number_format($cartTotal, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span class="text-success">
                                @if($cartTotal >= 100)
                                    Free
                                @else
                                    $10.00
                                @endif
                            </span>
                        </div>
                        
                        @if($cartTotal < 100)
                            <div class="alert alert-info py-2">
                                <small>Add ${{ number_format(100 - $cartTotal, 2) }} more for free shipping!</small>
                            </div>
                        @endif
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total:</span>
                            <span class="h5 fw-bold text-success">
                                ${{ number_format($cartTotal + ($cartTotal >= 100 ? 0 : 10), 2) }}
                            </span>
                        </div>

                        <!-- Checkout Button -->
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" onclick="proceedToCheckout()">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </button>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-3 text-center">
                            <small class="text-muted">We accept:</small>
                            <div class="mt-2">
                                <i class="fab fa-cc-visa fa-2x me-2 text-primary"></i>
                                <i class="fab fa-cc-mastercard fa-2x me-2 text-warning"></i>
                                <i class="fab fa-cc-paypal fa-2x me-2 text-info"></i>
                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="card mt-3">
                    <div class="card-body text-center py-3">
                        <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                        <div class="small text-muted">
                            <strong>Secure Checkout</strong><br>
                            Your information is protected with 256-bit SSL encryption
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="empty-cart-icon mb-4">
                        <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('user.home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.cart-product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.no-image-placeholder {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.cart-item:last-child {
    border-bottom: none !important;
}

.quantity-input {
    width: 60px;
}

.empty-cart-icon {
    opacity: 0.3;
}

.product-image-container {
    position: relative;
}

.price-section {
    text-align: center;
}

@media (max-width: 768px) {
    .cart-item .row > div {
        margin-bottom: 1rem;
    }
    
    .cart-item .row > div:last-child {
        margin-bottom: 0;
    }
}
</style>

<script>
function increaseQuantity(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.getAttribute('max'));
    
    if (currentValue < maxValue) {
        input.value = currentValue + 1;
        input.form.submit();
    }
}

function decreaseQuantity(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    const currentValue = parseInt(input.value);
    const minValue = parseInt(input.getAttribute('min'));
    
    if (currentValue > minValue) {
        input.value = currentValue - 1;
        input.form.submit();
    }
}

function proceedToCheckout() {
    // Create a form and submit to the cart checkout route
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("user.cart.checkout") }}';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfToken);
    
    // Submit the form
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
