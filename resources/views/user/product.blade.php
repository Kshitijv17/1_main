@extends('user.layout')

@section('title', $product->title)

@section('content')
<!-- Modern Product Detail Page -->
<div class="product-detail-page">
    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb" class="py-3">
            <ol class="breadcrumb modern-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="#">{{ $product->category->title }}</a></li>
                @endif
                <li class="breadcrumb-item active">{{ Str::limit($product->title, 30) }}</li>
            </ol>
        </nav>
    </div>

    <!-- Main Product Section -->
    <div class="container pb-5">
        <div class="row g-5">
            <!-- Product Images Gallery -->
            <div class="col-lg-6">
                <div class="product-gallery-container">
                    <!-- Main Image -->
                    <div class="main-image-wrapper">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="main-product-image" 
                                 alt="{{ $product->title }}" 
                                 id="mainImage">
                        @else
                            <div class="main-product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-spa fa-5x text-muted"></i>
                            </div>
                        @endif
                        
                        <!-- Product Badges -->
                        <div class="product-badges-overlay">
                            @if($product->is_featured)
                                <span class="badge featured-badge">Featured</span>
                            @endif
                            @if($discountPercentage > 0)
                                <span class="badge discount-badge">-{{ $discountPercentage }}%</span>
                            @endif
                        </div>
                        
                        <!-- Image Controls -->
                        <div class="image-controls">
                            <button class="btn btn-light btn-sm zoom-btn" onclick="zoomImage()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="btn btn-light btn-sm share-btn" onclick="shareProduct()">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Shop Info -->
                    <div class="shop-info mb-3">
                        <div class="d-flex align-items-center">
                            <div class="shop-avatar me-3">
                                <i class="fas fa-store"></i>
                            </div>
                            <div>
                                <h6 class="shop-name mb-0">{{ $product->shop->name }}</h6>
                                <small class="text-muted">Verified Seller</small>
                            </div>
                            <div class="ms-auto">
                                <div class="shop-rating">
                                    <i class="fas fa-star text-warning"></i>
                                    <span>4.8</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Title -->
                    <h1 class="product-title">{{ $product->title }}</h1>
                    
                    <!-- Category -->
                    @if($product->category)
                        <div class="product-category mb-3">
                            <span class="category-tag">{{ $product->category->title }}</span>
                        </div>
                    @endif

                    <!-- Rating and Reviews -->
                    <div class="product-rating mb-4">
                        <div class="d-flex align-items-center">
                            <div class="stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $averageRating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-value me-2">{{ $averageRating }}</span>
                            <span class="review-count text-muted">({{ $reviews->count() }} reviews)</span>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="product-pricing mb-4">
                        <div class="price-container">
                            @if($discountPercentage > 0)
                                <span class="current-price">${{ number_format($finalPrice, 2) }}</span>
                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                <span class="discount-percent">{{ $discountPercentage }}% OFF</span>
                            @else
                                <span class="current-price">${{ number_format($finalPrice, 2) }}</span>
                            @endif
                        </div>
                        <div class="price-details mt-2">
                            <small class="text-muted">Inclusive of all taxes</small>
                        </div>
                    </div>

                    <!-- Product Description -->
                    @if($product->description)
                        <div class="product-description mb-4">
                            <h6>Description</h6>
                            <div class="description-content">
                                {{ Str::limit($product->description, 200) }}
                                @if(strlen($product->description) > 200)
                                    <a href="#" class="read-more-btn" onclick="toggleDescription()">Read more</a>
                                @endif
                            </div>
                            @if(strlen($product->description) > 200)
                                <div class="full-description" style="display: none;">
                                    {{ $product->description }}
                                    <a href="#" class="read-less-btn" onclick="toggleDescription()">Read less</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Quantity Selector -->
                    <div class="quantity-section mb-4">
                        <h6>Quantity</h6>
                        <div class="quantity-controls">
                            <button class="btn btn-outline-secondary" onclick="decreaseQuantity()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="10" class="form-control quantity-input">
                            <button class="btn btn-outline-secondary" onclick="increaseQuantity()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <small class="text-muted">Maximum 10 items per order</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <button class="btn btn-primary btn-lg w-100 add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success btn-lg w-100 buy-now-btn" onclick="buyNow({{ $product->id }})">
                                    <i class="fas fa-bolt me-2"></i>
                                    Buy Now
                                </button>
                            </div>
                        </div>
                        
                        <!-- Secondary Actions -->
                        <div class="secondary-actions mt-3">
                            <div class="row g-2">
                                <div class="col-4">
                                    @auth
                                        <button class="btn btn-outline-secondary w-100 wishlist-btn" 
                                                data-product-id="{{ $product->id }}"
                                                onclick="toggleWishlist({{ $product->id }})">
                                            <i class="{{ auth()->user()->hasInWishlist($product->id) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                            <small class="d-block">{{ auth()->user()->hasInWishlist($product->id) ? 'Remove' : 'Wishlist' }}</small>
                                        </button>
                                    @else
                                        <button class="btn btn-outline-secondary w-100" onclick="showLoginModal()">
                                            <i class="far fa-heart"></i>
                                            <small class="d-block">Wishlist</small>
                                        </button>
                                    @endauth
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-outline-secondary w-100" onclick="compareProduct({{ $product->id }})">
                                        <i class="fas fa-exchange-alt"></i>
                                        <small class="d-block">Compare</small>
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-outline-secondary w-100" onclick="shareProduct()">
                                        <i class="fas fa-share-alt"></i>
                                        <small class="d-block">Share</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Info -->
                    <div class="delivery-info">
                        <div class="info-card">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-truck text-success me-2"></i>
                                <span class="fw-bold">Free Delivery</span>
                            </div>
                            <small class="text-muted">Get it by tomorrow, if ordered before 6 PM</small>
                        </div>
                        
                        <div class="info-card">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-undo text-info me-2"></i>
                                <span class="fw-bold">Easy Returns</span>
                            </div>
                            <small class="text-muted">7 days return policy</small>
                        </div>
                        
                        <div class="info-card">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-shield-alt text-warning me-2"></i>
                                <span class="fw-bold">Warranty</span>
                            </div>
                            <small class="text-muted">1 year manufacturer warranty</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="container">
        <div class="product-tabs-section">
            <ul class="nav nav-tabs modern-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        Reviews ({{ $reviews->count() }})
                    </button>
                </li>
            </ul>
            
            <div class="tab-content modern-tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <h5>Product Description</h5>
                        <div class="description-full">
                            {!! nl2br(e($product->description ?? 'No description available for this product.')) !!}
                        </div>
                        
                        @if($product->category)
                            <div class="mt-4">
                                <h6>Category Information</h6>
                                <p class="text-muted">This product belongs to the <strong>{{ $product->category->title }}</strong> category.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Specifications Tab -->
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <h5>Product Specifications</h5>
                        <div class="specifications-table">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="spec-label">Brand</td>
                                        <td>{{ $product->shop->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Category</td>
                                        <td>{{ $product->category->title ?? 'Uncategorized' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">SKU</td>
                                        <td>{{ $product->sku ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Weight</td>
                                        <td>{{ $product->weight ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Dimensions</td>
                                        <td>{{ $product->dimensions ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <div class="reviews-summary mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="rating-overview text-center">
                                        <div class="average-rating">{{ $averageRating }}</div>
                                        <div class="stars mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($averageRating))
                                                    <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $averageRating)
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">Based on {{ $reviews->count() }} reviews</small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="rating-breakdown">
                                        @php
                                            $breakdown = $product->rating_breakdown ?? [];
                                            $totalReviews = $reviews->count();
                                        @endphp
                                        @for($i = 5; $i >= 1; $i--)
                                            @php
                                                $count = $breakdown[$i] ?? 0;
                                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                            @endphp
                                            <div class="rating-bar d-flex align-items-center mb-1">
                                                <span class="rating-label">{{ $i }} star</span>
                                                <div class="progress flex-grow-1 mx-2">
                                                    <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="rating-count">{{ $count }}</span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Write Review Button -->
                        <div class="write-review-section mb-4">
                            @auth
                                @php
                                    $userReview = $reviews->where('user_id', auth()->id())->first();
                                @endphp
                                @if($userReview)
                                    <div class="user-review-notice">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div class="flex-grow-1">
                                                <strong>You have already reviewed this product</strong>
                                                <p class="mb-0 mt-1">Rating: 
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $userReview->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </p>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary me-2" onclick="editReview({{ $userReview->id }})">Edit</button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteReview({{ $userReview->id }})">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button class="btn btn-primary btn-lg" onclick="openReviewModal({{ $product->id }})">
                                        <i class="fas fa-star me-2"></i>Write a Review
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-outline-primary btn-lg" onclick="showLoginPrompt()">
                                    <i class="fas fa-star me-2"></i>Login to Write a Review
                                </button>
                            @endauth
                        </div>

                        <!-- Reviews List -->
                        <div class="reviews-list">
                            @if($reviews->count() > 0)
                                @foreach($reviews->take(5) as $review)
                                    <div class="review-item" data-review-id="{{ $review->id }}">
                                        <div class="review-header d-flex align-items-center mb-2">
                                            <div class="reviewer-avatar me-3">
                                                <div class="avatar-circle">
                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="reviewer-name mb-0">{{ $review->user->name }}</h6>
                                                <div class="review-meta d-flex align-items-center">
                                                    <div class="review-rating me-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <small class="text-muted">{{ $review->created_at->format('M j, Y') }}</small>
                                                    @if($review->is_verified)
                                                        <span class="badge bg-success ms-2">Verified Purchase</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($review->title)
                                            <h6 class="review-title">{{ $review->title }}</h6>
                                        @endif
                                        
                                        @if($review->comment)
                                            <p class="review-comment">{{ $review->comment }}</p>
                                        @endif
                                        
                                        <div class="review-actions d-flex align-items-center mt-3">
                                            <button class="btn btn-sm btn-outline-secondary helpful-btn" 
                                                    onclick="toggleHelpful({{ $review->id }})" 
                                                    data-helpful="{{ auth()->check() && $review->isHelpfulForUser(auth()->id()) ? 'true' : 'false' }}">
                                                <i class="fas fa-thumbs-up me-1"></i>
                                                Helpful (<span class="helpful-count">{{ $review->helpful_votes_count }}</span>)
                                            </button>
                                            
                                            @auth
                                                @if($review->user_id === auth()->id())
                                                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editReview({{ $review->id }})">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="deleteReview({{ $review->id }})">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr class="review-divider">
                                    @endif
                                @endforeach
                                
                                @if($reviews->count() > 5)
                                    <div class="text-center mt-4">
                                        <button class="btn btn-outline-primary" onclick="loadMoreReviews()">Load More Reviews</button>
                                    </div>
                                @endif
                            @else
                                <div class="no-reviews text-center py-5">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5>No reviews yet</h5>
                                    <p class="text-muted">Be the first to review this product!</p>
                                    @auth
                                        <button class="btn btn-primary" onclick="openReviewModal({{ $product->id }})">Write a Review</button>
                                    @else
                                        <button class="btn btn-outline-primary" onclick="showLoginPrompt()">Login to Write a Review</button>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="container mt-5">
            <div class="related-products-section">
                <h3 class="section-title">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-6">
                            <div class="product-card">
                                <div class="product-image">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->title }}">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-spa"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h6 class="product-name">{{ Str::limit($relatedProduct->title, 40) }}</h6>
                                    <div class="product-price">
                                        @if($relatedProduct->selling_price && $relatedProduct->selling_price < $relatedProduct->price)
                                            <span class="current-price">${{ number_format($relatedProduct->selling_price, 2) }}</span>
                                            <span class="original-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                        @else
                                            <span class="current-price">${{ number_format($relatedProduct->selling_price ?? $relatedProduct->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('user.product.show', $relatedProduct) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                        View Product
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">
                    <i class="fas fa-star text-warning me-2"></i>Write a Review
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <input type="hidden" id="reviewProductId" name="product_id">
                    <input type="hidden" id="reviewId" name="review_id">
                    
                    <!-- Star Rating -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Rating *</label>
                        <div class="star-rating-input">
                            <div class="stars-container">
                                <i class="fas fa-star star-input" data-rating="1"></i>
                                <i class="fas fa-star star-input" data-rating="2"></i>
                                <i class="fas fa-star star-input" data-rating="3"></i>
                                <i class="fas fa-star star-input" data-rating="4"></i>
                                <i class="fas fa-star star-input" data-rating="5"></i>
                            </div>
                            <div class="rating-text mt-2">
                                <span id="ratingText">Click to rate</span>
                            </div>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" required>
                    </div>
                    
                    <!-- Review Title -->
                    <div class="mb-3">
                        <label for="reviewTitle" class="form-label fw-bold">Review Title</label>
                        <input type="text" class="form-control" id="reviewTitle" name="title" 
                               placeholder="Summarize your experience" maxlength="255">
                    </div>
                    
                    <!-- Review Comment -->
                    <div class="mb-3">
                        <label for="reviewComment" class="form-label fw-bold">Your Review</label>
                        <textarea class="form-control" id="reviewComment" name="comment" rows="4" 
                                  placeholder="Share your thoughts about this product..." maxlength="1000"></textarea>
                        <div class="form-text">Maximum 1000 characters</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitReview">
                    <i class="fas fa-paper-plane me-2"></i>Submit Review
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Product Detail Page Styles */
.product-detail-page {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
}

.modern-breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.modern-breadcrumb .breadcrumb-item a {
    color: #22c55e;
    text-decoration: none;
    font-weight: 500;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: #6b7280;
}

/* Product Gallery */
.product-gallery-container {
    position: relative;
}

.main-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: white;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.main-product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.product-badges-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.featured-badge {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.discount-badge {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
}

.image-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.image-controls .btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.image-controls .btn:hover {
    background: #22c55e;
    color: white;
    transform: scale(1.1);
}

/* Product Info */
.product-info {
    padding: 20px;
}

.shop-info {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    padding: 15px;
    backdrop-filter: blur(10px);
}

.shop-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.shop-name {
    font-weight: 700;
    color: #1f2937;
}

.shop-rating {
    background: rgba(251, 191, 36, 0.1);
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.product-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1f2937;
    line-height: 1.2;
    margin-bottom: 15px;
}

.category-tag {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-rating .stars {
    font-size: 1.1rem;
}

.rating-value {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1f2937;
}

/* Pricing */
.price-container {
    display: flex;
    align-items: baseline;
    gap: 15px;
    flex-wrap: wrap;
}

.current-price {
    font-size: 2.5rem;
    font-weight: 800;
    color: #22c55e;
    line-height: 1;
}

.original-price {
    font-size: 1.5rem;
    color: #9ca3af;
    text-decoration: line-through;
    font-weight: 600;
}

.discount-percent {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* Quantity Controls */
.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0;
    max-width: 150px;
}

.quantity-controls .btn {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border-radius: 0;
    border-left: none;
    border-right: none;
    font-weight: 600;
}

/* Action Buttons */
.add-to-cart-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
}

.buy-now-btn {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
    border-radius: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.buy-now-btn:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
}

.secondary-actions .btn {
    border-radius: 12px;
    padding: 12px 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.secondary-actions .btn:hover {
    background: #f3f4f6;
    transform: translateY(-2px);
}

/* Delivery Info */
.delivery-info {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    padding: 20px;
    backdrop-filter: blur(10px);
}

.info-card {
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-card:last-child {
    border-bottom: none;
}

/* Product Tabs */
.product-tabs-section {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.modern-tabs {
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 30px;
}

.modern-tabs .nav-link {
    border: none;
    border-radius: 0;
    padding: 15px 25px;
    font-weight: 600;
    color: #6b7280;
    background: transparent;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.modern-tabs .nav-link.active {
    color: #22c55e;
    border-bottom-color: #22c55e;
    background: transparent;
}

.modern-tabs .nav-link:hover {
    color: #22c55e;
    border-bottom-color: rgba(34, 197, 94, 0.3);
}

.tab-content-wrapper {
    padding: 20px 0;
}

.specifications-table .spec-label {
    font-weight: 600;
    color: #374151;
    width: 150px;
}

.average-rating {
    font-size: 3rem;
    font-weight: 800;
    color: #22c55e;
}

.rating-breakdown .rating-label {
    width: 60px;
    font-size: 0.9rem;
}

.rating-breakdown .rating-count {
    width: 40px;
    text-align: right;
    font-size: 0.9rem;
    color: #6b7280;
}

/* Related Products */
.related-products-section {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 25px;
}

.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.product-card .product-image {
    height: 200px;
    overflow: hidden;
}

.product-card .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-card .no-image {
    height: 100%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 2rem;
}

.product-card .product-info {
    padding: 20px;
}

.product-card .product-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 10px;
    line-height: 1.3;
}

.product-card .current-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #22c55e;
}

.product-card .original-price {
    font-size: 0.9rem;
    color: #9ca3af;
    text-decoration: line-through;
    margin-left: 8px;
}

/* Review Styles */
.write-review-section {
    border-top: 1px solid #e5e7eb;
    padding-top: 20px;
}

.user-review-notice .alert {
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
}

.review-item {
    padding: 20px 0;
}

.reviewer-avatar .avatar-circle {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
}

.reviewer-name {
    font-weight: 600;
    color: #1f2937;
}

.review-rating .fa-star {
    font-size: 0.9rem;
}

.review-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.review-comment {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 0;
}

.review-divider {
    border-color: #f3f4f6;
    margin: 0;
}

.helpful-btn {
    border-radius: 20px;
    font-size: 0.85rem;
    padding: 6px 12px;
    transition: all 0.3s ease;
}

.helpful-btn:hover {
    background: #22c55e;
    border-color: #22c55e;
    color: white;
}

.helpful-btn.active {
    background: #22c55e;
    border-color: #22c55e;
    color: white;
}

/* Review Modal Styles */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid #f3f4f6;
    padding: 25px 30px 20px;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    border-top: 1px solid #f3f4f6;
    padding: 20px 30px 25px;
}

.star-rating-input {
    text-align: center;
    padding: 20px;
    background: #f9fafb;
    border-radius: 15px;
    border: 2px solid #e5e7eb;
    transition: border-color 0.3s ease;
}

.star-rating-input:hover {
    border-color: #fbbf24;
}

.stars-container {
    margin-bottom: 10px;
}

.star-input {
    font-size: 2.5rem;
    color: #d1d5db;
    cursor: pointer;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.star-input:hover,
.star-input.active {
    color: #fbbf24;
    transform: scale(1.1);
}

.rating-text {
    font-weight: 600;
    color: #6b7280;
    font-size: 1.1rem;
}

.form-label {
    color: #374151;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 12px 16px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .current-price {
        font-size: 2rem;
    }
    
    .main-product-image {
        height: 300px;
    }
    
    .action-buttons .col-6 {
        margin-bottom: 10px;
    }
    
    .secondary-actions .col-4 {
        margin-bottom: 10px;
    }
    
    .reviewer-avatar .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .star-input {
        font-size: 2rem;
        margin: 0 3px;
    }
    
    .modal-body,
    .modal-header,
    .modal-footer {
        padding: 20px;
    }
}
</style>

<script>
// Product Detail Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Quantity Controls
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.getAttribute('max'));
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.getAttribute('min'));
    
    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
    }
}

// Description Toggle
function toggleDescription() {
    const shortDesc = document.querySelector('.description-content');
    const fullDesc = document.querySelector('.full-description');
    
    if (fullDesc.style.display === 'none') {
        shortDesc.style.display = 'none';
        fullDesc.style.display = 'block';
    } else {
        shortDesc.style.display = 'block';
        fullDesc.style.display = 'none';
    }
}

// Image Zoom
function zoomImage() {
    const mainImage = document.getElementById('mainImage');
    // You can implement a modal or lightbox here
    alert('Image zoom functionality - implement modal/lightbox');
}

// Add to Cart Function
function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    const button = document.querySelector('.add-to-cart-btn');
    
    // Debug logging
    console.log('Adding to cart:', { productId, quantity });
    
    // Check if CSRF token exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('CSRF token not found. Please refresh the page.', 'error');
        return;
    }
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    button.disabled = true;
    
    // AJAX request to add to cart
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Product added to cart successfully!', 'success');
            
            // Update cart count in header if exists
            updateCartCount();
            
            // Reset button
            button.innerHTML = '<i class="fas fa-check me-2"></i>Added to Cart';
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
                button.disabled = false;
            }, 2000);
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
            button.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please check your connection and try again.', 'error');
        button.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
        button.disabled = false;
    });
}

// Buy Now Function
function buyNow(productId) {
    const quantity = document.getElementById('quantity').value;
    const button = document.querySelector('.buy-now-btn');
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    button.disabled = true;
    
    // AJAX request to create immediate order
    fetch('/api/orders/buy-now', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to checkout page
            window.location.href = data.checkout_url || '/checkout';
        } else {
            showNotification(data.message || 'Failed to process order', 'error');
            button.innerHTML = '<i class="fas fa-bolt me-2"></i>Buy Now';
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
        button.innerHTML = '<i class="fas fa-bolt me-2"></i>Buy Now';
        button.disabled = false;
    });
}

// Wishlist// Toggle Wishlist
function toggleWishlist(productId) {
    fetch('{{ route("user.wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const wishlistBtn = document.querySelector(`[data-product-id="${productId}"]`);
            const icon = wishlistBtn.querySelector('i');
            const text = wishlistBtn.querySelector('small');
            
            if (data.action === 'added') {
                icon.className = 'fas fa-heart text-danger';
                text.textContent = 'Remove';
                showNotification('Product added to wishlist!', 'success');
            } else {
                icon.className = 'far fa-heart';
                text.textContent = 'Wishlist';
                showNotification('Product removed from wishlist!', 'success');
            }
            
            // Update wishlist count in header
            updateWishlistCount(data.wishlist_count);
        } else {
            showNotification(data.message || 'Failed to update wishlist', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
}

// Show login modal for guests
function showLoginModal() {
    showNotification('Please login to add items to your wishlist', 'info');
    // You can trigger your login modal here
}

// Compare Product
function compareProduct(productId) {
    showNotification('Compare functionality coming soon!', 'info');
}

// Share Product
function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Product link copied to clipboard!', 'success');
        });
    }
}

// Review Modal Variables
let currentProductId = null;
let currentReviewId = null;
let selectedRating = 0;

// Open Review Modal
function openReviewModal(productId) {
    currentProductId = productId;
    currentReviewId = null;
    selectedRating = 0;
    
    // Reset form
    document.getElementById('reviewForm').reset();
    document.getElementById('reviewProductId').value = productId;
    document.getElementById('reviewId').value = '';
    document.getElementById('ratingValue').value = '';
    document.getElementById('ratingText').textContent = 'Click to rate';
    document.getElementById('reviewModalLabel').innerHTML = '<i class="fas fa-star text-warning me-2"></i>Write a Review';
    document.getElementById('submitReview').innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Review';
    
    // Reset stars
    document.querySelectorAll('.star-input').forEach(star => {
        star.classList.remove('active');
    });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
    modal.show();
}

// Edit Review
function editReview(reviewId) {
    // Fetch review data
    fetch(`/reviews/${reviewId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const review = data.review;
                currentReviewId = reviewId;
                currentProductId = review.product_id;
                selectedRating = review.rating;
                
                // Populate form
                document.getElementById('reviewProductId').value = review.product_id;
                document.getElementById('reviewId').value = reviewId;
                document.getElementById('reviewTitle').value = review.title || '';
                document.getElementById('reviewComment').value = review.comment || '';
                document.getElementById('ratingValue').value = review.rating;
                
                // Update modal title
                document.getElementById('reviewModalLabel').innerHTML = '<i class="fas fa-edit text-warning me-2"></i>Edit Review';
                document.getElementById('submitReview').innerHTML = '<i class="fas fa-save me-2"></i>Update Review';
                
                // Set stars
                updateStarRating(review.rating);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
                modal.show();
            } else {
                showNotification('Failed to load review data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading review data', 'error');
        });
}

// Delete Review
function deleteReview(reviewId) {
    if (!confirm('Are you sure you want to delete this review?')) {
        return;
    }
    
    fetch(`/reviews/${reviewId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Review deleted successfully!', 'success');
            // Remove review from DOM
            const reviewElement = document.querySelector(`[data-review-id="${reviewId}"]`);
            if (reviewElement) {
                reviewElement.remove();
            }
            // Reload page to update ratings
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Failed to delete review', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting review', 'error');
    });
}

// Toggle Helpful Vote
function toggleHelpful(reviewId) {
    const button = document.querySelector(`[onclick="toggleHelpful(${reviewId})"]`);
    const countSpan = button.querySelector('.helpful-count');
    
    fetch(`/reviews/${reviewId}/helpful`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            countSpan.textContent = data.helpful_count;
            if (data.is_helpful) {
                button.classList.add('active');
                button.setAttribute('data-helpful', 'true');
            } else {
                button.classList.remove('active');
                button.setAttribute('data-helpful', 'false');
            }
        } else {
            showNotification(data.message || 'Failed to update helpful vote', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating helpful vote', 'error');
    });
}

// Show Login Prompt
function showLoginPrompt() {
    showNotification('Please login to write a review', 'info');
    // You can redirect to login page or show login modal
    setTimeout(() => {
        window.location.href = '/login';
    }, 2000);
}

// Star Rating Functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-input');
    const ratingText = document.getElementById('ratingText');
    const ratingValue = document.getElementById('ratingValue');
    
    const ratingTexts = {
        1: 'Poor',
        2: 'Fair', 
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };
    
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            highlightStars(rating);
            ratingText.textContent = ratingTexts[rating];
        });
        
        star.addEventListener('mouseout', function() {
            if (selectedRating > 0) {
                highlightStars(selectedRating);
                ratingText.textContent = ratingTexts[selectedRating];
            } else {
                highlightStars(0);
                ratingText.textContent = 'Click to rate';
            }
        });
        
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.getAttribute('data-rating'));
            ratingValue.value = selectedRating;
            highlightStars(selectedRating);
            ratingText.textContent = ratingTexts[selectedRating];
        });
    });
    
    // Submit Review
    document.getElementById('submitReview').addEventListener('click', function() {
        submitReview();
    });
});

function highlightStars(rating) {
    const stars = document.querySelectorAll('.star-input');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

function updateStarRating(rating) {
    selectedRating = rating;
    const ratingTexts = {
        1: 'Poor',
        2: 'Fair', 
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };
    
    highlightStars(rating);
    document.getElementById('ratingText').textContent = ratingTexts[rating];
    document.getElementById('ratingValue').value = rating;
}

// Submit Review Function
function submitReview() {
    const form = document.getElementById('reviewForm');
    const formData = new FormData(form);
    const submitBtn = document.getElementById('submitReview');
    
    // Validation
    if (!selectedRating || selectedRating < 1) {
        showNotification('Please select a rating', 'error');
        return;
    }
    
    // Show loading state
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
    submitBtn.disabled = true;
    
    // Prepare data
    const reviewData = {
        product_id: currentProductId,
        rating: selectedRating,
        title: document.getElementById('reviewTitle').value,
        comment: document.getElementById('reviewComment').value
    };
    
    // Determine URL and method
    const isEdit = currentReviewId !== null;
    const url = isEdit ? `/reviews/${currentReviewId}` : '/reviews';
    const method = isEdit ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(reviewData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Review submitted successfully!', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
            modal.hide();
            
            // Reload page to show new review
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Failed to submit review', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error submitting review', 'error');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Load More Reviews
function loadMoreReviews() {
    // This would typically load more reviews via AJAX
    showNotification('Load more functionality coming soon!', 'info');
}

// Utility Functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function updateCartCount() {
    // Update cart count in navigation if exists
    fetch('/api/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.count || 0;
            });
        })
        .catch(error => console.error('Error updating cart count:', error));
}

function updateWishlistCount(count) {
    // Update wishlist count in navigation if exists
    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
    wishlistCountElements.forEach(element => {
        element.textContent = count || 0;
    });
}

// Initialize helpful button states
document.addEventListener('DOMContentLoaded', function() {
    // Set initial state for helpful buttons
    document.querySelectorAll('.helpful-btn').forEach(button => {
        const isHelpful = button.getAttribute('data-helpful') === 'true';
        if (isHelpful) {
            button.classList.add('active');
        }
    });
});
</script>
@endsection
