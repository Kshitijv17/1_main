@extends('user.layout')

@section('title', 'All Products - Shop Now')

@section('content')
<div class="products-page">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="filters-sidebar">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-filter me-2 text-primary"></i>Filters
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" method="GET" action="{{ route('user.products') }}">
                                <!-- Search -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Search Products</label>
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Search products..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Categories -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Categories</label>
                                    <div class="category-filters">
                                        @php
                                            $categories = \App\Models\Category::withCount('products')->orderBy('title')->get();
                                        @endphp
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="category" 
                                                   id="all_categories" value="" 
                                                   {{ !request('category') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="all_categories">
                                                All Categories
                                            </label>
                                        </div>
                                        @foreach($categories as $category)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="category" 
                                                       id="category_{{ $category->id }}" value="{{ $category->id }}"
                                                       {{ request('category') == $category->id ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category_{{ $category->id }}">
                                                    {{ $category->title }} 
                                                    <span class="text-muted">({{ $category->products_count }})</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Price Range</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="number" name="min_price" class="form-control" 
                                                   placeholder="Min ₹" value="{{ request('min_price') }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="max_price" class="form-control" 
                                                   placeholder="Max ₹" value="{{ request('max_price') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Status -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Availability</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="in_stock" 
                                               id="in_stock" value="1" 
                                               {{ request('in_stock') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="in_stock">
                                            In Stock Only
                                        </label>
                                    </div>
                                </div>

                                <!-- Filter Actions -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i>Apply Filters
                                    </button>
                                    <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Clear All
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Products Header -->
                <div class="products-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">All Products</h2>
                        <p class="text-muted mb-0">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} 
                            of {{ $products->total() }} products
                        </p>
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="sort-options">
                        <form method="GET" action="{{ route('user.products') }}" class="d-flex align-items-center gap-2">
                            <!-- Preserve existing filters -->
                            @foreach(request()->except(['sort', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <label class="form-label mb-0 me-2">Sort by:</label>
                            <select name="sort" class="form-select" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Default</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                    Name (A-Z)
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                    Name (Z-A)
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Price (Low to High)
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Price (High to Low)
                                </option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                    Newest First
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Oldest First
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="products-grid">
                        <div class="row g-4">
                            @foreach($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                    <div class="herb-product-card" onclick="window.location.href='{{ route('user.product.show', $product) }}'">
                                        <div class="herb-product-image">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                                            @else
                                                <div class="placeholder-image d-flex align-items-center justify-content-center bg-light" style="height: 100%; width: 100%;">
                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- Discount Badge -->
                                            @if($product->selling_price && $product->selling_price < $product->price)
                                                @php
                                                    $discount = round((($product->price - $product->selling_price) / $product->price) * 100);
                                                @endphp
                                                <div class="herb-discount-badge">-{{ $discount }}%</div>
                                            @endif
                                            
                                            <!-- Hover Overlay -->
                                            <div class="herb-product-overlay">
                                                @if($product->stock_status === 'in_stock' && $product->quantity > 0)
                                                    <button class="herb-add-to-cart-btn" onclick="event.stopPropagation(); addToCart({{ $product->id }})">
                                                        Add to Cart
                                                    </button>
                                                @else
                                                    <button class="herb-add-to-cart-btn" disabled onclick="event.stopPropagation()">
                                                        Out of Stock
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="herb-product-info">
                                            @if($product->category)
                                                <div class="herb-product-category">{{ strtoupper($product->category->title) }}</div>
                                            @endif
                                            <h3 class="herb-product-title">{{ Str::limit($product->title, 50) }}</h3>
                                            <div class="herb-product-price">
                                                @if($product->selling_price && $product->selling_price < $product->price)
                                                    <span class="herb-current-price">₹{{ number_format($product->selling_price, 2) }}</span>
                                                    <span class="herb-original-price">₹{{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="herb-current-price">₹{{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-section mt-5">
                        <div class="d-flex justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="no-products text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-search fa-4x text-muted"></i>
                        </div>
                        <h3 class="mb-3">No Products Found</h3>
                        <p class="text-muted mb-4">
                            We couldn't find any products matching your criteria. 
                            Try adjusting your filters or search terms.
                        </p>
                        <a href="{{ route('user.products') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-2"></i>View All Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.products-page {
    background-color: #f8f9fa;
}

.filters-sidebar .card {
    position: sticky;
    top: 100px;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

/* Herb Product Card Styles */
.herb-product-card {
    background: white;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.herb-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-color: #8B4513;
}

.herb-product-image {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
}

.herb-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.herb-product-card:hover .herb-product-image img {
    transform: scale(1.05);
}

.herb-discount-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    z-index: 2;
}

.herb-product-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    padding: 20px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.herb-product-card:hover .herb-product-overlay {
    transform: translateY(0);
}

.herb-add-to-cart-btn {
    background: #8B4513;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.herb-add-to-cart-btn:hover:not(:disabled) {
    background: #6d3410;
    transform: translateY(-2px);
}

.herb-add-to-cart-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

.herb-product-info {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.herb-product-category {
    font-size: 11px;
    color: #6c757d;
    letter-spacing: 1px;
    margin-bottom: 8px;
    font-weight: 500;
}

.herb-product-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.herb-product-price {
    margin-top: auto;
}

.herb-current-price {
    font-size: 18px;
    font-weight: bold;
    color: #8B4513;
}

.herb-original-price {
    font-size: 14px;
    color: #999;
    text-decoration: line-through;
    margin-left: 8px;
}

@media (max-width: 768px) {
    .products-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .sort-options {
        width: 100%;
    }
    
    .sort-options form {
        width: 100%;
    }
    
    .sort-options .form-select {
        width: 100% !important;
    }
    
    .herb-product-title {
        font-size: 14px;
    }
    
    .herb-current-price {
        font-size: 16px;
    }
    
    .herb-product-info {
        padding: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filter form on category change
    const categoryInputs = document.querySelectorAll('input[name="category"]');
    categoryInputs.forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
    
    // Auto-submit on availability checkbox change
    const stockCheckbox = document.getElementById('in_stock');
    if (stockCheckbox) {
        stockCheckbox.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    }
});

// Add to Cart Function
function addToCart(productId) {
    @auth
        fetch('{{ route("user.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                product_id: productId,
                quantity: 1 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Product added to cart!', 'success');
                updateCartCount(data.cart_count);
            } else {
                showToast(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong. Please try again.', 'error');
        });
    @else
        showToast('Please login to add items to your cart', 'info');
    @endauth
}
</script>
@endsection
