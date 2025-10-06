@extends('user.layout')

@section('title', 'My Wishlist - HerbnHouse')

@section('content')
<div class="wishlist-page">
    <!-- Hero Section -->
    <div class="wishlist-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="hero-title">My Wishlist</h1>
                        <p class="hero-subtitle">Your favorite products saved for later</p>
                        <div class="breadcrumb-nav">
                            <a href="{{ route('user.home') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">•</span>
                            <span class="breadcrumb-current">Wishlist</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $wishlistItems->total() }}</div>
                            <div class="stat-label">Items Saved</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist Content -->
    <div class="wishlist-content">
        <div class="container">
            @if($wishlistItems->count() > 0)
                <!-- Wishlist Actions -->
                <div class="wishlist-actions">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="results-info">
                                Showing {{ $wishlistItems->firstItem() }}-{{ $wishlistItems->lastItem() }} of {{ $wishlistItems->total() }} items
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="action-buttons">
                                <button class="btn btn-outline-danger btn-sm" id="clearWishlist">
                                    <i class="fas fa-trash me-2"></i>Clear All
                                </button>
                                <button class="btn btn-primary btn-sm" id="addAllToCart">
                                    <i class="fas fa-shopping-cart me-2"></i>Add All to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Grid -->
                <div class="wishlist-grid">
                    <div class="row g-4">
                        @foreach($wishlistItems as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6" data-product-id="{{ $product->id }}">
                                <div class="wishlist-card">
                                    <!-- Product Image -->
                                    <div class="product-image-container">
                                        <a href="{{ route('user.product.show', $product) }}" class="product-image-link">
                                            @if($product->images->count() > 0)
                                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="product-image">
                                            @else
                                                <div class="product-image-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </a>
                                        
                                        <!-- Quick Actions -->
                                        <div class="product-actions">
                                            <button class="action-btn remove-wishlist" 
                                                    data-product-id="{{ $product->id }}"
                                                    title="Remove from Wishlist">
                                                <i class="fas fa-heart-broken"></i>
                                            </button>
                                            <button class="action-btn quick-view" 
                                                    data-product-id="{{ $product->id }}"
                                                    title="Quick View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>

                                        <!-- Product Badge -->
                                        @if($product->quantity <= 5)
                                            <div class="product-badge badge-warning">Low Stock</div>
                                        @elseif($product->created_at->diffInDays() <= 7)
                                            <div class="product-badge badge-success">New</div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="product-info">
                                        <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                        <h3 class="product-name">
                                            <a href="{{ route('user.product.show', $product) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="product-shop">
                                            <i class="fas fa-store me-1"></i>
                                            {{ $product->shop->name ?? 'Unknown Shop' }}
                                        </div>
                                        
                                        <!-- Product Price -->
                                        <div class="product-pricing">
                                            <div class="current-price">₹{{ number_format($product->price, 2) }}</div>
                                            @if($product->compare_price && $product->compare_price > $product->price)
                                                <div class="original-price">₹{{ number_format($product->compare_price, 2) }}</div>
                                                <div class="discount-percent">
                                                    {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Actions -->
                                        <div class="product-cart-actions">
                                            @if($product->quantity > 0)
                                                <button class="btn btn-primary btn-add-cart" 
                                                        data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                                </button>
                                            @else
                                                <button class="btn btn-secondary" disabled>
                                                    <i class="fas fa-times me-2"></i>Out of Stock
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Added Date -->
                                        <div class="wishlist-date">
                                            <small class="text-muted">
                                                <i class="fas fa-heart me-1"></i>
                                                Added {{ $product->pivot->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($wishlistItems->hasPages())
                    <div class="wishlist-pagination">
                        {{ $wishlistItems->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            @else
                <!-- Empty Wishlist -->
                <div class="empty-wishlist">
                    <div class="empty-content">
                        <div class="empty-icon">
                            <i class="fas fa-heart-broken"></i>
                        </div>
                        <h2 class="empty-title">Your Wishlist is Empty</h2>
                        <p class="empty-description">
                            Looks like you haven't added any products to your wishlist yet. 
                            Start browsing and save your favorite items!
                        </p>
                        <div class="empty-actions">
                            <a href="{{ route('user.home') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                            </a>
                            <a href="{{ route('user.product.search') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Browse Products
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="wishlistToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-heart text-danger me-2"></i>
            <strong class="me-auto">Wishlist</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* HerbnHouse-inspired Wishlist Styles */
.wishlist-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
}

.wishlist-hero {
    background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
    color: white;
    padding: 4rem 0 3rem;
    position: relative;
    overflow: hidden;
}

.wishlist-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.breadcrumb-link {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.breadcrumb-separator {
    opacity: 0.6;
}

.breadcrumb-current {
    color: #90ee90;
    font-weight: 500;
}

.hero-stats {
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #90ee90;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-top: 0.5rem;
}

.wishlist-content {
    padding: 4rem 0;
}

.wishlist-actions {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(45,90,39,0.1);
}

.results-info {
    color: #666;
    font-size: 0.95rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.wishlist-grid {
    margin-bottom: 3rem;
}

.wishlist-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(45,90,39,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.wishlist-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.product-image-container {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.wishlist-card:hover .product-image {
    transform: scale(1.05);
}

.product-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f9f6 0%, #e8f5e8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2d5a27;
    font-size: 3rem;
}

.product-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.wishlist-card:hover .product-actions {
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.9);
    color: #2d5a27;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.action-btn:hover {
    background: #2d5a27;
    color: white;
    transform: scale(1.1);
}

.remove-wishlist:hover {
    background: #dc3545;
    color: white;
}

.product-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-warning {
    background: #ffc107;
    color: #000;
}

.badge-success {
    background: #28a745;
    color: white;
}

.product-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category {
    color: #2d5a27;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.product-name a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: #2d5a27;
}

.product-shop {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.product-pricing {
    margin-bottom: 1rem;
}

.current-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d5a27;
    line-height: 1;
}

.original-price {
    font-size: 0.9rem;
    color: #999;
    text-decoration: line-through;
    margin-top: 0.25rem;
}

.discount-percent {
    font-size: 0.8rem;
    color: #dc3545;
    font-weight: 600;
    margin-top: 0.25rem;
}

.product-cart-actions {
    margin-top: auto;
    margin-bottom: 1rem;
}

.btn-add-cart {
    width: 100%;
    background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
    border: none;
    padding: 0.75rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(45,90,39,0.3);
}

.wishlist-date {
    border-top: 1px solid #eee;
    padding-top: 0.75rem;
    margin-top: auto;
}

.empty-wishlist {
    text-align: center;
    padding: 4rem 0;
}

.empty-icon {
    font-size: 5rem;
    color: #ddd;
    margin-bottom: 2rem;
}

.empty-title {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

.empty-description {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.wishlist-pagination {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .action-buttons {
        justify-content: flex-start;
        margin-top: 1rem;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .empty-actions .btn {
        width: 100%;
        max-width: 300px;
    }
}

/* Toast Styling */
.toast {
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.toast-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token Setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.getElementById('wishlistToast');
        const toastBody = toast.querySelector('.toast-body');
        const toastHeader = toast.querySelector('.toast-header');
        
        toastBody.textContent = message;
        
        if (type === 'error') {
            toastHeader.querySelector('i').className = 'fas fa-exclamation-triangle text-warning me-2';
        } else {
            toastHeader.querySelector('i').className = 'fas fa-heart text-danger me-2';
        }
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
    
    // Remove from wishlist
    document.querySelectorAll('.remove-wishlist').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productCard = this.closest('[data-product-id]');
            
            fetch('{{ route("user.wishlist.remove") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    productCard.style.transform = 'scale(0)';
                    productCard.style.opacity = '0';
                    setTimeout(() => {
                        productCard.remove();
                        
                        // Check if wishlist is empty
                        const remainingItems = document.querySelectorAll('[data-product-id]');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 300);
                    
                    showToast(data.message);
                    updateWishlistCount(data.wishlist_count);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
            });
        });
    });
    
    // Add to cart functionality
    document.querySelectorAll('.btn-add-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Add to cart logic here
            showToast('Product added to cart!');
        });
    });
    
    // Clear all wishlist
    document.getElementById('clearWishlist')?.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your entire wishlist?')) {
            // Clear all wishlist logic here
            location.reload();
        }
    });
    
    // Add all to cart
    document.getElementById('addAllToCart')?.addEventListener('click', function() {
        // Add all to cart logic here
        showToast('All available items added to cart!');
    });
    
    // Update wishlist count in header
    function updateWishlistCount(count) {
        const wishlistCountElements = document.querySelectorAll('.wishlist-count');
        wishlistCountElements.forEach(element => {
            element.textContent = count;
        });
    }
});
</script>
@endpush
