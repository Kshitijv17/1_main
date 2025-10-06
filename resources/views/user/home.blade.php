@extends('user.layout')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-75">
            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-content px-5">
                    <div class="hero-badge mb-3">
                        <span class="badge-text">Best products</span>
                    </div>
                    <h1 class="hero-title mb-4">Best products for hair growth</h1>
                    <p class="hero-subtitle mb-4">Get 25% Off on Your First Purchase!</p>
                    <button class="hero-btn">
                        Explore Now
                    </button>
                </div>
            </div>
            <div class="col-lg-6 position-relative hero-image-section">
                <!-- Hero Image with decorative elements -->
                <div class="hero-image-container">
                    <div class="hero-main-image">
                        <img src="https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=400&fit=crop" alt="Hair care products" class="img-fluid rounded-3">
                    </div>
                    <!-- Floating decorative elements -->
                    <div class="floating-element element-1">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=100&h=100&fit=crop" alt="Plant" class="rounded-3">
                    </div>
                    <div class="floating-element element-2">
                        <img src="https://images.unsplash.com/photo-1493663284031-b7e3aaa4c4bc?w=80&h=80&fit=crop" alt="Camera" class="rounded-3">
                    </div>
                    <div class="floating-element element-3">
                        <div class="decorative-circle"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Row -->
        <div class="stats-section py-4">
            <div class="container">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="stat-item">
                            <h3 class="stat-number">{{ $stats['total_products'] ?? '175' }}+</h3>
                            <p class="stat-label">Products</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <h3 class="stat-number">{{ $stats['total_shops'] ?? '50' }}+</h3>
                            <p class="stat-label">Shops</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <h3 class="stat-number">{{ $stats['total_categories'] ?? '25' }}+</h3>
                            <p class="stat-label">Categories</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-item">
                            <h3 class="stat-number">1000+</h3>
                            <p class="stat-label">Happy Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trending Products Section -->
<section class="products-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <span>— Trending Product —</span>
            </div>
            <h2 class="section-title">Trending Product</h2>
            <p class="section-subtitle">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
        </div>
        
        <div class="row g-4">
            @if($featuredProducts && $featuredProducts->count() > 0)
                @foreach($featuredProducts->take(8) as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="herb-product-card" onclick="window.location.href='{{ route('user.product.show', $product) }}'">
                            <div class="herb-card-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="herb-product-img">
                                @else
                                    <div class="herb-image-placeholder">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                @endif
                                
                                @if($product->selling_price && $product->selling_price < $product->price)
                                    @php
                                        $discount = round((($product->price - $product->selling_price) / $product->price) * 100);
                                    @endphp
                                    <div class="herb-discount-badge">-{{ $discount }}%</div>
                                @endif
                                
                                <div class="herb-card-overlay">
                                    <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart({{ $product->id }})">
                                        Add to Cart
                                    </button>
                                    @auth
                                        <button class="herb-wishlist-btn" 
                                                data-product-id="{{ $product->id }}"
                                                onclick="event.stopPropagation(); toggleWishlistFromCard({{ $product->id }})">
                                            <i class="{{ auth()->user()->hasInWishlist($product->id) ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                        </button>
                                    @else
                                        <button class="herb-wishlist-btn" onclick="event.stopPropagation(); showLoginModal()">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                            
                            <div class="herb-card-content">
                                <div class="herb-product-category">{{ $product->category->title ?? 'Herbal Products' }}</div>
                                <h3 class="herb-product-title">{{ Str::limit($product->title, 40) }}</h3>
                                <div class="herb-product-rating">
                                    <div class="herb-stars">
                                        @php
                                            $rating = round($product->average_rating);
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp
                                        @for($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @if($halfStar)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif
                                        @for($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="herb-rating-text">({{ $product->reviews_count }})</span>
                                </div>
                                <div class="herb-product-price">
                                    @if($product->selling_price && $product->selling_price < $product->price)
                                        <span class="herb-current-price">${{ number_format($product->selling_price, 2) }}</span>
                                        <span class="herb-original-price">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="herb-current-price">${{ number_format($product->selling_price ?? $product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default herb-style product cards if no featured products -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="herb-product-card">
                        <div class="herb-card-image">
                            <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400&h=400&fit=crop" alt="Herbal Tea" class="herb-product-img">
                            <div class="herb-discount-badge">-23%</div>
                            <div class="herb-card-overlay">
                                <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart(1)">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="herb-card-content">
                            <div class="herb-product-category">Herbal Teas</div>
                            <h3 class="herb-product-title">Organic Chamomile Tea</h3>
                            <div class="herb-product-price">
                                <span class="herb-current-price">$19.99</span>
                                <span class="herb-original-price">$25.99</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="herb-product-card">
                        <div class="herb-card-image">
                            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=400&fit=crop" alt="Essential Oil" class="herb-product-img">
                            <div class="herb-discount-badge">-20%</div>
                            <div class="herb-card-overlay">
                                <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart(2)">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="herb-card-content">
                            <div class="herb-product-category">Essential Oils</div>
                            <h3 class="herb-product-title">Lavender Essential Oil</h3>
                            <div class="herb-product-price">
                                <span class="herb-current-price">$32.00</span>
                                <span class="herb-original-price">$40.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="herb-product-card">
                        <div class="herb-card-image">
                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop" alt="Herbal Supplement" class="herb-product-img">
                            <div class="herb-card-overlay">
                                <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart(3)">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="herb-card-content">
                            <div class="herb-product-category">Supplements</div>
                            <h3 class="herb-product-title">Turmeric Capsules</h3>
                            <div class="herb-product-price">
                                <span class="herb-current-price">$24.99</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="herb-product-card">
                        <div class="herb-card-image">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=400&fit=crop" alt="Herbal Skincare" class="herb-product-img">
                            <div class="herb-discount-badge">-15%</div>
                            <div class="herb-card-overlay">
                                <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart(4)">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="herb-card-content">
                            <div class="herb-product-category">Skincare</div>
                            <h3 class="herb-product-title">Aloe Vera Face Cream</h3>
                            <div class="herb-product-price">
                                <span class="herb-current-price">$29.99</span>
                                <span class="herb-original-price">$35.99</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('user.products') }}" class="view-all-btn">View All Products</a>
        </div>
    </div>
</section>

<!-- Best Selling Products Section -->
<section class="products-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <span>— Best Selling Product —</span>
            </div>
            <h2 class="section-title">Best Selling Product</h2>
            <p class="section-subtitle">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
        </div>
        
        <div class="row g-4">
            @if($products && $products->count() > 0)
                @foreach($products->take(8) as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="herb-product-card" onclick="window.location.href='{{ route('user.product.show', $product) }}'">
                            <div class="herb-card-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="herb-product-img">
                                @else
                                    <div class="herb-image-placeholder">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                @endif
                                
                                @if($product->selling_price && $product->selling_price < $product->price)
                                    @php
                                        $discount = round((($product->price - $product->selling_price) / $product->price) * 100);
                                    @endphp
                                    <div class="herb-discount-badge">-{{ $discount }}%</div>
                                @endif
                                
                                <div class="herb-card-overlay">
                                    <button class="herb-add-to-cart" onclick="event.stopPropagation(); addToCart({{ $product->id }})">
                                        Add to Cart
                                    </button>
                                    <button class="herb-write-review" onclick="event.stopPropagation(); openReviewModal({{ $product->id }})">
                                        Write Review
                                    </button>
                                </div>
                            </div>
                            
                            <div class="herb-card-content">
                                <div class="herb-product-category">{{ $product->category->title ?? 'Herbal Products' }}</div>
                                <h3 class="herb-product-title">{{ Str::limit($product->title, 40) }}</h3>
                                <div class="herb-product-rating">
                                    <div class="herb-stars">
                                        @php
                                            $rating = round($product->average_rating);
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp
                                        @for($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @if($halfStar)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif
                                        @for($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="herb-rating-text">({{ $product->reviews_count }})</span>
                                </div>
                                <div class="herb-product-price">
                                    @if($product->selling_price && $product->selling_price < $product->price)
                                        <span class="herb-current-price">${{ number_format($product->selling_price, 2) }}</span>
                                        <span class="herb-original-price">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="herb-current-price">${{ number_format($product->selling_price ?? $product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default modern product cards for best selling -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="modern-product-card">
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1505944270255-72b8c68c6a70?w=400&h=400&fit=crop" alt="Herbal Powder" class="product-main-image">
                            <div class="product-badges">
                                <span class="badge bestseller-badge">Best Seller</span>
                                <span class="badge discount-badge">-25%</span>
                            </div>
                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="action-btn compare-btn" title="Compare">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                            <div class="add-to-cart-overlay">
                                <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(5)">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">
                                <span class="category-link">Herbal Powders</span>
                            </div>
                            <h3 class="product-name">Organic Amla Powder</h3>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count">(4.9)</span>
                            </div>
                            <div class="product-pricing">
                                <span class="sale-price">$18.99</span>
                                <span class="regular-price">$24.99</span>
                            </div>
                            <div class="product-shop">
                                <i class="fas fa-store me-1"></i>
                                <span>Ayurvedic Store</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="modern-product-card">
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?w=400&h=400&fit=crop" alt="Herbal Soap" class="product-main-image">
                            <div class="product-badges">
                                <span class="badge bestseller-badge">Top Rated</span>
                            </div>
                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="action-btn compare-btn" title="Compare">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                            <div class="add-to-cart-overlay">
                                <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(6)">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">
                                <span class="category-link">Natural Soaps</span>
                            </div>
                            <h3 class="product-name">Neem & Tulsi Soap</h3>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="rating-count">(4.6)</span>
                            </div>
                            <div class="product-pricing">
                                <span class="sale-price">$12.99</span>
                            </div>
                            <div class="product-shop">
                                <i class="fas fa-store me-1"></i>
                                <span>Natural Care</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="modern-product-card">
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1559181567-c3190ca9959b?w=400&h=400&fit=crop" alt="Herbal Oil" class="product-main-image">
                            <div class="product-badges">
                                <span class="badge bestseller-badge">Popular</span>
                                <span class="badge discount-badge">-30%</span>
                            </div>
                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="action-btn compare-btn" title="Compare">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                            <div class="add-to-cart-overlay">
                                <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(7)">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">
                                <span class="category-link">Hair Oils</span>
                            </div>
                            <h3 class="product-name">Coconut Hair Oil</h3>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count">(4.8)</span>
                            </div>
                            <div class="product-pricing">
                                <span class="sale-price">$16.99</span>
                                <span class="regular-price">$24.99</span>
                            </div>
                            <div class="product-shop">
                                <i class="fas fa-store me-1"></i>
                                <span>Organic Oils</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="modern-product-card">
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop" alt="Herbal Balm" class="product-main-image">
                            <div class="product-badges">
                                <span class="badge bestseller-badge">Trending</span>
                            </div>
                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="action-btn compare-btn" title="Compare">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                            <div class="add-to-cart-overlay">
                                <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(8)">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-category">
                                <span class="category-link">Pain Relief</span>
                            </div>
                            <h3 class="product-name">Ayurvedic Pain Balm</h3>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-count">(4.3)</span>
                            </div>
                            <div class="product-pricing">
                                <span class="sale-price">$22.99</span>
                            </div>
                            <div class="product-shop">
                                <i class="fas fa-store me-1"></i>
                                <span>Wellness Hub</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('user.products') }}" class="view-all-btn">View All Products</a>
        </div>
    </div>
</section>

<!-- Kind Words Section -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <span>— Kind Words —</span>
            </div>
            <h2 class="section-title">Kind Words</h2>
            <p class="section-subtitle">From our Users</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5 col-md-6">
                <div class="testimonial-card testimonial-left">
                    <div class="testimonial-content">
                        <p>"Absolutely love this Amla Powder! My hair feels thicker and shinier after just two weeks of use. and I ordered during the Buy 1 Get 1 offer. Great value and amazing quality!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar-wrapper">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face" alt="User" class="author-avatar">
                        </div>
                        <div class="author-info">
                            <h6 class="author-name">Aditya Jain, Jaipur</h6>
                            <span class="author-role">User</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-6">
                <div class="testimonial-card testimonial-right">
                    <div class="testimonial-content">
                        <p>"My skin looks so much clearer and brighter now! I've been mixing the Amla Powder with rose water as a face mask—totally obsessed!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar-wrapper">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="User" class="author-avatar">
                        </div>
                        <div class="author-info">
                            <h6 class="author-name">Riya Sharma, Chandigarh</h6>
                            <span class="author-role">User</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* Hero Section Styles */
.hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 80vh;
}

.min-vh-75 {
    min-height: 75vh;
}

.hero-content {
    padding: 4rem 0;
}

.hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.9);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    color: #666;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 2rem;
}

.hero-btn {
    background: #8B4513;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hero-btn:hover {
    background: #A0522D;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 69, 19, 0.3);
}

/* Hero Image Section */
.hero-image-section {
    padding: 2rem;
}

.hero-image-container {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-main-image {
    position: relative;
    z-index: 2;
}

.hero-main-image img {
    width: 400px;
    height: 300px;
    object-fit: cover;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.floating-element {
    position: absolute;
    z-index: 1;
}

.element-1 {
    top: 20px;
    right: 50px;
    width: 100px;
    height: 100px;
}

.element-1 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.element-2 {
    bottom: 50px;
    right: 20px;
    width: 80px;
    height: 80px;
}

.element-2 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.element-3 {
    top: 50px;
    left: 20px;
}

.decorative-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #84cc16, #65a30d);
    border-radius: 50%;
    box-shadow: 0 10px 20px rgba(132, 204, 22, 0.3);
}

/* Stats Section */
.stats-section {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
}

/* Section Headers */
.section-header {
    margin-bottom: 3rem;
}

.section-badge {
    margin-bottom: 1rem;
}

.section-badge span {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Reset Bootstrap and other conflicting styles */
.modern-product-card.card,
.modern-product-card .card-body,
.modern-product-card .card-img-top {
    all: unset !important;
}

/* Override Bootstrap grid spacing */
.products-section .row .col-lg-3,
.products-section .row .col-md-6,
.products-section .row .col-sm-6 {
    padding: 15px !important;
}

/* Modern Product Card - Premium Design with Higher Specificity */
.products-section .modern-product-card,
.row .col-lg-3 .modern-product-card,
div.modern-product-card {
    /* Force reset any inherited styles */
    all: unset !important;
    
    /* Premium card styling with !important for override */
    display: block !important;
    width: 100% !important;
    height: auto !important;
    min-height: 500px !important;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%) !important;
    border-radius: 28px !important;
    overflow: hidden !important;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.12) !important,
        0 16px 64px rgba(0, 0, 0, 0.06) !important,
        inset 0 1px 0 rgba(255, 255, 255, 0.8) !important;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1) !important;
    cursor: pointer !important;
    position: relative !important;
    border: 2px solid rgba(34, 197, 94, 0.1) !important;
    backdrop-filter: blur(20px) !important;
    
    /* Ensure proper box model */
    box-sizing: border-box !important;
    margin: 0 !important;
    padding: 0 !important;
    
    /* Add subtle gradient border */
    background-clip: padding-box !important;
    
    /* Ensure it's visible */
    opacity: 1 !important;
    visibility: visible !important;
}

.products-section .modern-product-card:hover,
.row .col-lg-3 .modern-product-card:hover,
div.modern-product-card:hover {
    transform: translateY(-20px) scale(1.04) !important;
    box-shadow: 
        0 24px 80px rgba(0, 0, 0, 0.18) !important,
        0 48px 120px rgba(0, 0, 0, 0.10) !important,
        inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
    border: 2px solid rgba(34, 197, 94, 0.3) !important;
}

.modern-product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.02) 0%, rgba(16, 185, 129, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 0;
    border-radius: 24px;
}

.modern-product-card:hover::before {
    opacity: 1;
}

.product-image-container {
    position: relative;
    width: 100%;
    height: 300px;
    overflow: hidden;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f8fafc 100%);
    display: block;
    z-index: 1;
    
    /* Add subtle inner shadow */
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.06);
}

.product-main-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    object-position: center;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
    border: none;
    outline: none;
    display: block;
    filter: brightness(1) saturate(1) contrast(1);
}

.modern-product-card:hover .product-main-image {
    transform: scale(1.08);
    filter: brightness(1.05) saturate(1.1) contrast(1.02);
}

.product-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #28a745;
    font-size: 3rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Modern Product Badges */
.product-badges {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.badge {
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.15),
        0 8px 32px rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.featured-badge {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #ffffff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.discount-badge {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.bestseller-badge {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

/* Modern Product Actions */
.product-actions {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    gap: 12px;
    opacity: 0;
    transform: translateX(30px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
}

.modern-product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.action-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.9);
    color: #374151;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.12),
        0 8px 32px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    font-size: 16px;
}

.action-btn:hover {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    transform: scale(1.15);
    box-shadow: 
        0 8px 30px rgba(34, 197, 94, 0.3),
        0 12px 40px rgba(0, 0, 0, 0.08);
}

/* Modern Add to Cart Overlay */
.add-to-cart-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(
        to top, 
        rgba(0, 0, 0, 0.9) 0%, 
        rgba(0, 0, 0, 0.6) 50%, 
        transparent 100%
    );
    padding: 24px 20px;
    transform: translateY(100%);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    backdrop-filter: blur(10px);
}

.modern-product-card:hover .add-to-cart-overlay {
    transform: translateY(0);
}

.add-to-cart-btn {
    width: 100%;
    padding: 16px 24px;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 
        0 4px 20px rgba(34, 197, 94, 0.3),
        0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.add-to-cart-btn:hover {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 
        0 8px 30px rgba(34, 197, 94, 0.4),
        0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Modern Product Content */
.product-content {
    padding: 28px 24px 32px 24px;
    background: linear-gradient(145deg, #ffffff 0%, #fafbfc 100%);
    display: block;
    width: 100%;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    border-top: 1px solid rgba(0, 0, 0, 0.04);
}

.product-category {
    margin-bottom: 10px;
}

.category-link {
    font-size: 0.75rem;
    color: #22c55e;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: rgba(34, 197, 94, 0.1);
    padding: 4px 12px;
    border-radius: 20px;
    display: inline-block;
    transition: all 0.3s ease;
}

.category-link:hover {
    background: rgba(34, 197, 94, 0.15);
    transform: scale(1.05);
}

.product-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 14px;
    line-height: 1.4;
    min-height: 3rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    letter-spacing: -0.02em;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}

.stars {
    color: #fbbf24;
    font-size: 0.95rem;
    display: flex;
    gap: 2px;
}

.rating-count {
    font-size: 0.8rem;
    color: #6b7280;
    font-weight: 600;
    background: rgba(107, 114, 128, 0.1);
    padding: 2px 8px;
    border-radius: 12px;
}

.product-pricing {
    display: flex;
    align-items: baseline;
    gap: 12px;
    margin-bottom: 16px;
}

.sale-price {
    font-size: 1.5rem;
    font-weight: 800;
    color: #22c55e;
    letter-spacing: -0.02em;
}

.regular-price {
    font-size: 1.1rem;
    color: #9ca3af;
    text-decoration: line-through;
    font-weight: 600;
}

.product-shop {
    display: flex;
    align-items: center;
    font-size: 0.8rem;
    color: #6b7280;
    padding-top: 16px;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    font-weight: 600;
    gap: 6px;
}

.product-shop i {
    color: #22c55e;
    font-size: 0.9rem;
}

/* Old Product Cards (fallback) */
.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.product-image-wrapper {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    font-size: 2rem;
}

.product-info {
    padding: 1.5rem;
}

.product-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.current-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
}

.original-price {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
}

/* View All Button */
.view-all-btn {
    background: transparent;
    border: 2px solid #2c3e50;
    color: #2c3e50;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: #2c3e50;
    color: white;
}

/* Testimonials */
.testimonials-section {
    background: #ffffff;
    padding: 80px 0;
}

.testimonial-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: none;
    border: 1px solid #e9ecef;
    height: 100%;
    position: relative;
    margin: 0 15px;
}

.testimonial-left {
    border-left: 4px solid #8B4513;
}

.testimonial-right {
    border-left: 4px solid #28a745;
}

.testimonial-content {
    margin-bottom: 2rem;
}

.testimonial-content p {
    font-size: 1.1rem;
    color: #333;
    line-height: 1.7;
    margin: 0;
    font-style: italic;
    font-weight: 400;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

.author-avatar-wrapper {
    position: relative;
}

.author-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.author-info {
    flex: 1;
}

.author-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 4px 0;
    line-height: 1.2;
}

.author-role {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 400;
}

/* Testimonials responsive */
@media (max-width: 768px) {
    .testimonial-card {
        margin: 0;
        padding: 2rem;
    }
    
    .testimonial-content p {
        font-size: 1rem;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-image-container {
        height: 300px;
    }
    
    .hero-main-image img {
        width: 300px;
        height: 200px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}

/* Force complete card structure */
.modern-product-card {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.modern-product-card .product-content {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    background: white !important;
    padding: 25px 20px !important;
}

.modern-product-card .product-name,
.modern-product-card .product-rating,
.modern-product-card .product-pricing,
.modern-product-card .product-shop,
.modern-product-card .product-category {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Bulletproof image sizing with higher specificity */
.products-section img.product-main-image,
.products-section .product-main-image,
.modern-product-card img.product-main-image,
.modern-product-card .product-main-image {
    width: 100% !important;
    height: 300px !important;
    object-fit: cover !important;
    object-position: center !important;
    display: block !important;
    border: none !important;
    outline: none !important;
    max-width: 100% !important;
    max-height: 300px !important;
    min-width: 100% !important;
    min-height: 300px !important;
    border-radius: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Container must be fixed size with higher specificity */
.products-section .modern-product-card .product-image-container,
.modern-product-card .product-image-container,
.product-image-container {
    width: 100% !important;
    height: 300px !important;
    overflow: hidden !important;
    position: relative !important;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f8fafc 100%) !important;
    display: block !important;
    z-index: 1 !important;
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.06) !important;
    margin: 0 !important;
    padding: 0 !important;
    border-radius: 0 !important;
}

/* Image handling for dynamic content */
.product-main-image {
    /* Fallback for browsers that don't support object-fit */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

/* Ensure images load properly */
.product-main-image[src=""], 
.product-main-image:not([src]), 
.product-main-image[src*="placeholder"] {
    display: none;
}

.product-main-image[src=""]:after, 
.product-main-image:not([src]):after, 
.product-main-image[src*="placeholder"]:after {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Handle broken images */
.product-main-image {
    position: relative;
}

.product-main-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    z-index: -1;
}

/* Image loading states */
.product-main-image {
    opacity: 1;
    transition: opacity 0.3s ease, transform 0.4s ease;
}

.product-main-image:not([complete]) {
    opacity: 0;
}

.product-main-image[complete] {
    opacity: 1;
}

/* Responsive Design for Modern Cards */
@media (max-width: 768px) {
    .modern-product-card {
        margin-bottom: 2rem;
    }
    
    .modern-product-card .product-image-container {
        height: 220px !important;
    }
    
    .modern-product-card .product-main-image,
    .modern-product-card img.product-main-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }
    
    .product-content {
        padding: 20px 15px;
    }
    
    .product-name {
        font-size: 1rem;
        min-height: 2.4rem;
    }
    
    .sale-price {
        font-size: 1.2rem;
    }
    
    .product-actions {
        opacity: 1;
        transform: translateX(0);
        position: static;
        flex-direction: row;
        justify-content: center;
        padding: 10px;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .add-to-cart-overlay {
        position: static;
        transform: translateY(0);
        background: transparent;
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .modern-product-card {
        border-radius: 15px;
    }
    
    .product-image-container {
        height: 200px;
    }
    
    .product-badges {
        top: 10px;
        left: 10px;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}
</style>

<script>
// Add to Cart functionality
function addToCart(productId) {
    // Show loading state
    const btn = event.target.closest('.add-to-cart-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    btn.disabled = true;
    
    // Simulate API call (replace with actual implementation)
    setTimeout(() => {
        // Show success message
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Added!';
        btn.style.background = 'linear-gradient(135deg, #28a745, #34ce57)';
        
        // Reset after 2 seconds
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.style.background = '';
        }, 2000);
        
        // Show notification
        showNotification('Product added to cart successfully!', 'success');
    }, 1000);
}

// Wishlist functionality
document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const icon = this.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.background = '#ff4757';
                this.style.color = 'white';
                showNotification('Added to wishlist!', 'success');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.style.background = '';
                this.style.color = '';
                showNotification('Removed from wishlist!', 'info');
            }
        });
    });
});

// Quick View functionality
document.addEventListener('DOMContentLoaded', function() {
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Quick view feature coming soon!', 'info');
        });
    });
});

// Compare functionality
document.addEventListener('DOMContentLoaded', function() {
    const compareBtns = document.querySelectorAll('.compare-btn');
    
    compareBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Compare feature coming soon!', 'info');
        });
    });
});

// Notification system
function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `custom-notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 300px;
        animation: slideInRight 0.3s ease;
        backdrop-filter: blur(10px);
    `;
    
    // Add to document
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Handle dynamic image sizing
document.addEventListener('DOMContentLoaded', function() {
    const productImages = document.querySelectorAll('.product-main-image');
    
    productImages.forEach(img => {
        // Handle image load
        img.addEventListener('load', function() {
            this.style.opacity = '1';
            this.setAttribute('complete', 'true');
        });
        
        // Handle image error
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.parentElement.querySelector('.product-image-placeholder');
            if (!placeholder) {
                const newPlaceholder = document.createElement('div');
                newPlaceholder.className = 'product-image-placeholder';
                newPlaceholder.innerHTML = '<i class="fas fa-spa"></i>';
                this.parentElement.appendChild(newPlaceholder);
            }
        });
        
        // Check if image is already loaded
        if (img.complete && img.naturalHeight !== 0) {
            img.style.opacity = '1';
            img.setAttribute('complete', 'true');
        }
    });
});

// Lazy loading for better performance
function setupLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('.product-main-image[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Initialize lazy loading
document.addEventListener('DOMContentLoaded', setupLazyLoading);

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 0;
        margin-left: 15px;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    
    .notification-close:hover {
        opacity: 1;
    }
`;
document.head.appendChild(style);

// Review Modal Functions
function openReviewModal(productId) {
    if (!@json(Auth::check())) {
        alert('Please login to write a review.');
        return;
    }
    
    document.getElementById('reviewProductId').value = productId;
    document.getElementById('reviewModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    resetReviewForm();
}

function resetReviewForm() {
    document.getElementById('reviewForm').reset();
    document.getElementById('reviewRating').value = '';
    document.querySelectorAll('.review-stars-input i').forEach(star => {
        star.className = 'far fa-star';
    });
    document.querySelector('.review-rating-text').textContent = 'Click to rate';
}

// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.review-stars-input i');
    const ratingInput = document.getElementById('reviewRating');
    const ratingText = document.querySelector('.review-rating-text');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            
            // Update star display
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.className = 'fas fa-star';
                } else {
                    s.className = 'far fa-star';
                }
            });
            
            // Update rating text
            const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = ratingTexts[rating];
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#e9ecef';
                }
            });
        });
    });
    
    document.querySelector('.review-stars-input').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        stars.forEach((s, i) => {
            if (i < currentRating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#e9ecef';
            }
        });
    });
});

// Review form submission
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    if (!data.rating) {
        alert('Please select a rating.');
        return;
    }
    
    fetch('{{ route("user.reviews.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Review submitted successfully!');
            closeReviewModal();
            // Optionally refresh the page or update the UI
            location.reload();
        } else {
            alert(data.message || 'Error submitting review.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting review.');
    });
});
</script>

<!-- Review Modal -->
<div id="reviewModal" class="review-modal" style="display: none;">
    <div class="review-modal-backdrop" onclick="closeReviewModal()"></div>
    <div class="review-modal-content">
        <div class="review-modal-header">
            <h3 class="review-modal-title">
                <i class="fas fa-star text-yellow-500 mr-2"></i>
                Write a Review
            </h3>
            <button class="review-modal-close" onclick="closeReviewModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="reviewForm" class="review-form">
            <input type="hidden" id="reviewProductId" name="product_id">
            
            <div class="review-form-group">
                <label class="review-form-label">Rating *</label>
                <div class="review-rating-input">
                    <div class="review-stars-input">
                        <i class="far fa-star" data-rating="1"></i>
                        <i class="far fa-star" data-rating="2"></i>
                        <i class="far fa-star" data-rating="3"></i>
                        <i class="far fa-star" data-rating="4"></i>
                        <i class="far fa-star" data-rating="5"></i>
                    </div>
                    <span class="review-rating-text">Click to rate</span>
                </div>
                <input type="hidden" id="reviewRating" name="rating" required>
            </div>
            
            <div class="review-form-group">
                <label for="reviewTitle" class="review-form-label">Review Title</label>
                <input type="text" id="reviewTitle" name="title" class="review-form-input" placeholder="Give your review a title">
            </div>
            
            <div class="review-form-group">
                <label for="reviewComment" class="review-form-label">Your Review</label>
                <textarea id="reviewComment" name="comment" class="review-form-textarea" rows="4" placeholder="Tell others about your experience with this product..."></textarea>
            </div>
            
            <div class="review-form-actions">
                <button type="button" class="review-btn-cancel" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="review-btn-submit">Submit Review</button>
            </div>
        </form>
    </div>
</div>

@endsection
