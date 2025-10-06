@extends('user.layout')

@section('title', 'About Us - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </div>
    </nav>

    <!-- About Us Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">About HerbnHouse</h1>
                    <p class="lead text-muted">Empowering Wellness & Conscious Living</p>
                </div>

                <!-- Main Content -->
                <div class="row mb-5">
                    <div class="col-md-6 mb-4">
                        <div class="bg-light p-4 rounded-3 h-100">
                            <h3 class="h4 fw-bold text-dark mb-3">Our Mission</h3>
                            <p class="text-muted">
                                Herb & House is more than a store—it's a thriving ecosystem connecting conscious consumers with authentic Ayurvedic practitioners, artisan decor makers, Health wellness, Household things, Office supplies and sustainable daily essentials.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="bg-light p-4 rounded-3 h-100">
                            <h3 class="h4 fw-bold text-dark mb-3">Founded in 2024</h3>
                            <p class="text-muted">
                                We're on a mission to revive traditional wellness and craftsmanship while supporting small businesses and ethical sourcing.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Who We Are Section -->
                <div class="mb-5">
                    <h2 class="h3 fw-bold text-dark mb-4">Who We Are</h2>
                    <div class="bg-white border rounded-3 p-4 shadow-sm">
                        <p class="text-muted mb-4">
                            <strong>"Empowering Wellness & Conscious Living – A Marketplace for Authentic Ayurveda, Handcrafted Décor & Daily Essentials Households"</strong>
                        </p>
                        <p class="text-muted mb-0">
                            Born from a commitment to deliver exceptional quality at unbeatable prices, our in-house brands are as unique as they are united each thoughtfully crafted to delight our valued users with style, value, and purpose.
                        </p>
                    </div>
                </div>

                <!-- Our Values -->
                <div class="mb-5">
                    <h2 class="h3 fw-bold text-dark mb-4">Our Values</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-leaf text-success fs-4"></i>
                                </div>
                                <h4 class="h6 fw-bold">Natural & Organic</h4>
                                <p class="small text-muted">100% natural and organic products for your wellness</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-handshake text-primary fs-4"></i>
                                </div>
                                <h4 class="h6 fw-bold">Ethical Sourcing</h4>
                                <p class="small text-muted">Supporting small businesses and fair trade practices</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-star text-warning fs-4"></i>
                                </div>
                                <h4 class="h6 fw-bold">Quality First</h4>
                                <p class="small text-muted">Exceptional quality at unbeatable prices</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="text-center bg-light p-4 rounded-3">
                    <h3 class="h4 fw-bold text-dark mb-3">Get in Touch</h3>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="fas fa-phone text-success me-2"></i>
                                <a href="tel:+916376191966" class="text-decoration-none text-dark">+91 6376191966</a>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-envelope text-success me-2"></i>
                                <a href="mailto:theherbandhouse@gmail.com" class="text-decoration-none text-dark">theherbandhouse@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb-item + .breadcrumb-item::before {
    color: #6c757d;
}

.breadcrumb-item a:hover {
    color: #8B4513 !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.text-success {
    color: #8B4513 !important;
}

.bg-success {
    background-color: #8B4513 !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>
@endsection
