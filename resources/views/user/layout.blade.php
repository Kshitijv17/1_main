<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome in company')</title>
    
    <!-- owl carasoul | owl carasoul theme css -->
    <link rel="stylesheet" href="https://herbandhouse.com/public/front/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://herbandhouse.com/public/front/css/owl.theme.default.min.css" />
    <!-- bootstrap | bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--main css | responsive css | common css-->
    <link rel="stylesheet" href="https://herbandhouse.com/public/front/css/common.css" />
    <link rel="stylesheet" href="https://herbandhouse.com/public/front/css/style.css" />
    <link rel="stylesheet" href="https://herbandhouse.com/public/front/css/responsive.css" />
    
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
        
        /* Search Offcanvas Styling */
        .offcanvas-end {
            width: 400px !important;
        }
        
        .search-wrapper-widget {
            padding: 0;
        }
        
        .category-select:focus,
        .search-input:focus {
            border-color: #8B4513 !important;
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
            outline: none;
        }
        
        /* Sticky Header Styles */
        #header {
            transition: all 0.3s ease-in-out;
        }
        
        #header.sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Hide header-top and header-middle when sticky */
        #header.sticky .header-top,
        #header.sticky .header-middle {
            display: none !important;
        }
        
        /* Keep only header-bottom visible when sticky */
        #header.sticky .header-bottom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Add smooth transitions for header sections */
        .header-top,
        .header-middle,
        .header-bottom {
            transition: all 0.3s ease-in-out;
        }
        
        /* Add top padding to body when header becomes sticky */
        body.header-sticky {
            padding-top: 0;
        }
        
        .search-button:hover {
            color: #8B4513 !important;
        }
        
        .products-infoBox {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .serch-info-products {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        
        .serch-info-products:hover {
            background-color: #f8f9fa;
        }
        
        .search-imgBox {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .search-imgBox img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .line-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        
        .transitionBox:hover {
            color: #8B4513 !important;
        }
        
        /* Dropdown styling */
        .dropMenu {
            position: relative;
        }
        
        .drop-down {
            display: none;
            position: absolute;
            background: #fff;
            border: 1px solid #eee;
            min-width: 200px;
            z-index: 1000;
            top: 100%;
            left: 0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dropMenu:hover .drop-down {
            display: block;
        }
        
        .menu-list {
            display: flex;
            align-items: center;
            gap: 2px;
            text-decoration: none;
            padding: 25px 10px;
            cursor: pointer;
        }
        
        .menu-list a {
            font-size: 15px;
        }
        
        .drop-down li {
            list-style: none;
        }
        
        .drop-down li a {
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            color: #333;
        }
        
        .drop-down li a:hover {
            background-color: #f2f2f2;
        }
        
        .dropdown-toggle-icon {
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        
        .dropdown-toggle-icon svg {
            transition: transform 0.2s ease;
        }
        
        .dropMenu:hover .dropdown-toggle-icon svg {
            transform: rotate(180deg);
        }
        
        /* Profile Dropdown Styling */
        .profile-dropdown .dropdown-menu {
            min-width: 220px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 0;
            margin-top: 8px;
        }
        
        .profile-dropdown .dropdown-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 12px 16px;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 8px 8px 0 0;
        }
        
        .profile-dropdown .dropdown-item {
            padding: 10px 16px;
            font-size: 14px;
            color: #333;
            transition: all 0.2s ease;
        }
        
        .profile-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #8B4513;
        }
        
        .profile-dropdown .dropdown-item i {
            width: 16px;
            color: #666;
        }
        
        .profile-dropdown .dropdown-item.text-danger:hover {
            background-color: #fff5f5;
            color: #dc3545;
        }
        
        .profile-icon {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .profile-icon:hover {
            transform: scale(1.1);
        }
        
        /* Herb & House Style Product Cards */
        .herb-product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #f0f0f0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .herb-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #e0e0e0;
        }
        
        .herb-card-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1;
            background: #f8f9fa;
        }
        
        .herb-product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .herb-product-card:hover .herb-product-img {
            transform: scale(1.05);
        }
        
        .herb-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #6c757d;
            font-size: 2rem;
        }
        
        .herb-discount-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }
        
        .herb-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            padding: 20px 15px 15px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .herb-product-card:hover .herb-card-overlay {
            transform: translateY(0);
        }
        
        .herb-add-to-cart, .herb-write-review {
            width: 100%;
            background: #fff;
            color: #333;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .herb-add-to-cart:hover {
            background: #8B4513;
            color: white;
            transform: translateY(-2px);
        }
        
        .herb-write-review:hover {
            background: #ffc107;
            color: #333;
            transform: translateY(-2px);
        }
        
        .herb-wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            z-index: 2;
        }
        
        .herb-wishlist-btn:hover {
            background: #fff;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .herb-wishlist-btn i {
            font-size: 16px;
            color: #8B4513;
            transition: color 0.3s ease;
        }
        
        .herb-wishlist-btn i.fas {
            color: #dc3545;
        }
        
        .herb-card-content {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .herb-product-category {
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .herb-product-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }
        
        .herb-product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }
        
        .herb-stars {
            display: flex;
            gap: 2px;
        }
        
        .herb-stars i {
            font-size: 12px;
            color: #ffc107;
        }
        
        .herb-stars i.far {
            color: #e9ecef;
        }
        
        .herb-rating-text {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }
        
        .herb-product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }
        
        .herb-current-price {
            font-size: 18px;
            font-weight: 700;
            color: #8B4513;
        }
        
        .herb-original-price {
            font-size: 14px;
            color: #6c757d;
            text-decoration: line-through;
        }
        
        /* Review Modal Styles */
        .review-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .review-modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .review-modal-content {
            position: relative;
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .review-modal-header {
            padding: 24px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .review-modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .review-modal-close {
            background: none;
            border: none;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            color: #6c757d;
            transition: all 0.2s ease;
        }
        
        .review-modal-close:hover {
            background: #f8f9fa;
            color: #333;
        }
        
        .review-form {
            padding: 24px;
        }
        
        .review-form-group {
            margin-bottom: 20px;
        }
        
        .review-form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .review-rating-input {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .review-stars-input {
            display: flex;
            gap: 4px;
        }
        
        .review-stars-input i {
            font-size: 24px;
            color: #e9ecef;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
        .review-stars-input i:hover {
            color: #ffc107;
        }
        
        .review-rating-text {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }
        
        .review-form-input, .review-form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s ease;
            font-family: inherit;
        }
        
        .review-form-input:focus, .review-form-textarea:focus {
            outline: none;
            border-color: #ffc107;
        }
        
        .review-form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .review-form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
        }
        
        .review-btn-cancel, .review-btn-submit {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        
        .review-btn-cancel {
            background: #f8f9fa;
            color: #6c757d;
        }
        
        .review-btn-cancel:hover {
            background: #e9ecef;
            color: #333;
        }
        
        .review-btn-submit {
            background: #8B4513;
            color: white;
        }
        
        .review-btn-submit:hover {
            background: #7a3a0f;
            transform: translateY(-1px);
        }

        /* Mobile Navigation Styles */
        .mobile-nav-item {
            transition: background-color 0.2s ease;
            font-size: 16px;
        }
        
        .mobile-nav-item:hover {
            background-color: #f8f9fa !important;
        }
        
        .mobile-nav-dropdown .collapse {
            transition: all 0.3s ease;
        }
        
        .mobile-submenu-item {
            font-size: 15px;
            transition: background-color 0.2s ease;
        }
        
        .mobile-submenu-item:hover {
            background-color: #e9ecef !important;
        }
        
        .mobile-user-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .mobile-contact-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 0 15px;
        }
        
        /* Header Responsive Improvements */
        @media (max-width: 991.98px) {
            .header-middle {
                display: none;
            }
            
            .header-top {
                padding: 8px 0;
            }
            
            .header-top .Shop-Smart {
                font-size: 12px;
                padding: 0 10px;
            }
            
            .header-bt-details {
                padding: 10px 0;
            }
            
            .nav-linkContainer {
                display: none;
            }
            
            .eCommerce-btn {
                gap: 15px;
            }
            
            .eCommerce-btn .d-none.d-lg-block {
                display: none !important;
            }
            
            .logo img {
                max-height: 45px;
                width: auto;
            }
        }
        
        @media (max-width: 767.98px) {
            .header-top .Shop-Smart {
                font-size: 11px;
                line-height: 1.3;
            }
            
            .header-bt-details {
                padding: 8px 0;
            }
            
            .logo img {
                max-height: 40px;
            }
            
            .eCommerce-btn {
                gap: 10px;
            }
            
            .toggle {
                font-size: 24px !important;
            }
            
            .countBox {
                width: 18px;
                height: 18px;
                font-size: 10px;
                top: -8px;
                right: -8px;
            }
        }
        
        @media (max-width: 575.98px) {
            .header-top .Shop-Smart {
                font-size: 10px;
                padding: 0 5px;
            }
            
            .logo img {
                max-height: 35px;
            }
            
            .eCommerce-btn {
                gap: 8px;
            }
            
            .nav-icon {
                width: 20px;
                height: 20px;
            }
        }
        
        /* Offcanvas Mobile Menu Improvements */
        .offcanvas-start {
            width: 300px !important;
        }
        
        @media (max-width: 575.98px) {
            .offcanvas-start {
                width: 280px !important;
            }
        }
        
        /* Mobile Menu Animation */
        .mobile-nav-dropdown .bi-chevron-down {
            transition: transform 0.3s ease;
        }
        
        .mobile-nav-dropdown .collapsed .bi-chevron-down {
            transform: rotate(-90deg);
        }
        
        /* Search Offcanvas Mobile Improvements */
        @media (max-width: 575.98px) {
            .offcanvas-end {
                width: 100% !important;
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .herb-product-card {
                margin-bottom: 20px;
            }
            
            .herb-product-title {
                font-size: 15px;
            }
            
            .herb-current-price {
                font-size: 16px;
            }
            
            .review-modal-content {
                margin: 10px;
                max-width: none;
            }
            
            .review-form-actions {
                flex-direction: column;
            }
            
            .review-btn-cancel, .review-btn-submit {
                width: 100%;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Load SweetAlert FIRST -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Your flash message logic -->
    <div class="flash-message text-center" style="z-index:111111; position:fixed; top:0; right:0;">
    </div>
    
    <header id="header">
        <div class="header-top py-2">
            <div class="container">
                <div class="text-white Shop-Smart text-center font-12 font-normal d-flex align-items-center justify-content-center">
                    Today's Top Deals – Shop Smart, Save Big! || Today's Trending Deals – Shop the Best, Pay Less! || Fresh Deals Every Day Start
                    <a class="d-flex align-items-center gap-1 text-white fw-bold ms-2" href="{{ route('user.home') }}">
                        <span><i class="bi bi-arrow-right"></i> Show Now</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="header-middle py-3">
            <div class="container">
                <div class="header-middle-details d-flex align-items-center justify-content-between gap-2">
                    <div class="d-none d-lg-block">
                        <div class="d-flex align-items-center gap-3">
                            <a class="font-12 text-black d-flex align-items-center gap-1" href="{{ route('user.home') }}">
                                <span><i class="bi bi-telephone"></i></span>
                                +91 6376191966
                            </a>
                            <a class="font-12 text-black d-flex align-items-center gap-1" href="{{ route('user.home') }}">
                                <span><i class="bi bi-envelope"></i></span>
                                theherbandhouse@gmail.com
                            </a>
                        </div>
                    </div>
                    <div class="font-12 text-black">
                        <span>Your Favorite Products, Now at Summary Sale Prices! || Exclusive Summary Sale – Best Picks at Best Prices!</span>
                        <a class="font-12 fw-bold text-black" href="{{ route('user.home') }}">
                            <i class="bi bi-arrow-right"></i> Show Now
                        </a>
                    </div>
                    <div class="location-details d-flex align-items-center gap-3 font-12">
                        <div class="dropdown currency-dropdown">
                            <button class="font-12 dropdown-toggle border-0 outline-0 bg-transparent" type="button" id="currencyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                ₹/85/INR
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
                                <li class="py-2">
                                    <a href="javascript:void(0);" class="dropdown-item">₹ - INR</a>
                                </li>
                                <li class="py-2">
                                    <a href="javascript:void(0);" class="dropdown-item">$ - USA</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header-bottom shadow-sm">
            <div class="container">
                <div class="header-bt-details d-flex align-items-center justify-content-between">
                    <a class="logo" href="{{ route('user.home') }}">
                        <img src="https://herbandhouse.com/public/front/images/logo 1.jpg" alt="logo.png" />
                    </a>
                    
                    <div class="nav-linkContainer">
                        <ul class="nav-link d-flex align-items-center gap-3">
                            <div class="mobileLogoButton d-flex justify-content-between align-items-center w-100 mb-4">
                                <a class="mobile-logo d-block" href="{{ route('user.home') }}">
                                    <img src="https://herbandhouse.com/public/front/images/logo 1.jpg" alt="logo" />
                                </a>
                                <button class="closeMenuBtn outline-0 border-0 d-flex align-items-center justify-content-center font-24 text-white">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            
                            <ul class="main-menu d-flex">
                                <li class="dropMenu navs">
                                    <div class="menu-list text-color fw-medium">
                                        <a href="{{ route('user.home') }}" class="text-color fw-medium">All Products</a>
                                        <span class="dropdown-toggle-icon" onclick="toggleDropdown(this)">
                                            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M36 18L24 30L12 18" stroke="#3f3c3c" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <ul class="drop-down">
                                        @php
                                            $categories = \App\Models\Category::orderBy('title')->get();
                                        @endphp
                                        @foreach($categories as $category)
                                            <li>
                                                <a class="fw-medium text-color" href="{{ route('user.category', $category) }}">
                                                    {{ $category->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="dropMenu navs">
                                    <div class="menu-list text-color fw-medium">
                                        <a href="{{ route('user.home') }}" class="text-color fw-medium">Show Now</a>
                                    </div>
                                </li>
                            </ul>
                        </ul>
                    </div>
                    
                    <div class="eCommerce-btn d-flex align-items-center gap-3">
                        <a class="search-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchButton">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.33333 10.6667C5.12222 10.6667 4.09733 10.2471 3.25867 9.408C2.42 8.56889 2.00044 7.544 2 6.33333C1.99956 5.12267 2.41911 4.09778 3.25867 3.25867C4.09822 2.41956 5.12311 2 6.33333 2C7.54356 2 8.56867 2.41956 9.40867 3.25867C10.2487 4.09778 10.668 5.12267 10.6667 6.33333C10.6667 6.82222 10.5889 7.28333 10.4333 7.71667C10.2778 8.15 10.0667 8.53333 9.8 8.86667L13.5333 12.6C13.6556 12.7222 13.7167 12.8778 13.7167 13.0667C13.7167 13.2556 13.6556 13.4111 13.5333 13.5333C13.4111 13.6556 13.2556 13.7167 13.0667 13.7167C12.8778 13.7167 12.7222 13.6556 12.6 13.5333L8.86667 9.8C8.53333 10.0667 8.15 10.2778 7.71667 10.4333C7.28333 10.5889 6.82222 10.6667 6.33333 10.6667ZM6.33333 9.33333C7.16667 9.33333 7.87511 9.04178 8.45867 8.45867C9.04222 7.87556 9.33378 7.16711 9.33333 6.33333C9.33289 5.49956 9.04133 4.79133 8.45867 4.20867C7.876 3.626 7.16756 3.33422 6.33333 3.33333C5.49911 3.33244 4.79089 3.62422 4.20867 4.20867C3.62644 4.79311 3.33467 5.50133 3.33333 6.33333C3.332 7.16533 3.62378 7.87378 4.20867 8.45867C4.79356 9.04356 5.50178 9.33511 6.33333 9.33333Z" fill="black" />
                        @auth
                            <a class="wishlisht-icon position-relative d-none d-lg-block" href="{{ route('user.wishlist') }}" title="My Wishlist">
                                <span>
                                    <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.24 12.25C3.84461 11.8572 3.53134 11.3897 3.31845 10.8747C3.10556 10.3596 2.99731 9.80733 3 9.25002C3 8.12285 3.44777 7.04184 4.2448 6.24481C5.04183 5.44778 6.12283 5.00002 7.25 5.00002C8.83 5.00002 10.21 5.86002 10.94 7.14002H12.06C12.4311 6.48908 12.9681 5.94811 13.6163 5.57219C14.2645 5.19628 15.0007 4.99886 15.75 5.00002C16.8772 5.00002 17.9582 5.44778 18.7552 6.24481C19.5522 7.04184 20 8.12285 20 9.25002C20 10.42 19.5 11.5 18.76 12.25L11.5 19.5L4.24 12.25ZM19.46 12.96C20.41 12 21 10.7 21 9.25002C21 7.85763 20.4469 6.52227 19.4623 5.53771C18.4777 4.55314 17.1424 4.00002 15.75 4.00002C14 4.00002 12.45 4.85002 11.5 6.17002C11.0151 5.49652 10.3766 4.94834 9.63748 4.57095C8.89835 4.19356 8.0799 3.99784 7.25 4.00002C5.85761 4.00002 4.52226 4.55314 3.53769 5.53771C2.55312 6.52227 2 7.85763 2 9.25002C2 10.7 2.59 12 3.54 12.96L11.5 20.92L19.46 12.96Z" fill="black"></path>
                                    </svg>
                                </span>
                                <div class="countBox position-absolute bg-black d-flex align-items-center justify-content-center -circle text-white text-center wishlist-count">
                                    {{ auth()->user()->wishlists()->count() }}
                                </div>
                            </a>
                        @else
                            <a class="wishlisht-icon position-relative d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="#" title="Login to view wishlist">
                                <span>
                                    <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.24 12.25C3.84461 11.8572 3.53134 11.3897 3.31845 10.8747C3.10556 10.3596 2.99731 9.80733 3 9.25002C3 8.12285 3.44777 7.04184 4.2448 6.24481C5.04183 5.44778 6.12283 5.00002 7.25 5.00002C8.83 5.00002 10.21 5.86002 10.94 7.14002H12.06C12.4311 6.48908 12.9681 5.94811 13.6163 5.57219C14.2645 5.19628 15.0007 4.99886 15.75 5.00002C16.8772 5.00002 17.9582 5.44778 18.7552 6.24481C19.5522 7.04184 20 8.12285 20 9.25002C20 10.42 19.5 11.5 18.76 12.25L11.5 19.5L4.24 12.25ZM19.46 12.96C20.41 12 21 10.7 21 9.25002C21 7.85763 20.4469 6.52227 19.4623 5.53771C18.4777 4.55314 17.1424 4.00002 15.75 4.00002C14 4.00002 12.45 4.85002 11.5 6.17002C11.0151 5.49652 10.3766 4.94834 9.63748 4.57095C8.89835 4.19356 8.0799 3.99784 7.25 4.00002C5.85761 4.00002 4.52226 4.55314 3.53769 5.53771C2.55312 6.52227 2 7.85763 2 9.25002C2 10.7 2.59 12 3.54 12.96L11.5 20.92L19.46 12.96Z" fill="black"></path>
                                    </svg>
                                </span>
                                <div class="countBox position-absolute bg-black d-flex align-items-center justify-content-center -circle text-white text-center">0</div>
                            </a>
                        @endauth
                        
                        <!-- Profile/User Icon -->
                        @auth
                            <div class="dropdown profile-dropdown d-none d-lg-block">
                                <a class="profile-icon position-relative d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>
                                        <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="black"/>
                                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="black"/>
                                        </svg>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="dropdown-header">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-person me-2"></i>My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.wishlist') }}"><i class="bi bi-heart me-2"></i>My Wishlist</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.my-orders') }}"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.my-account') }}"><i class="bi bi-gear me-2"></i>Account Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('user.logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="profile-icon position-relative d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="#" title="Login / Register">
                                <span>
                                    <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="black"/>
                                        <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="black"/>
                                    </svg>
                                </span>
                            </a>
                        @endauth
                        
                        <a class="cart-icon position-relative" href="{{ route('user.cart') }}">
                            <span>
                                <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 18C16.5304 18 17.0391 18.2107 17.4142 18.5858C17.7893 18.9609 18 19.4696 18 20C18 20.5304 17.7893 21.0391 17.4142 21.4142C17.0391 21.7893 16.5304 22 16 22C15.4696 22 14.9609 21.7893 14.5858 21.4142C14.2107 21.0391 14 20.5304 14 20C14 19.4696 14.2107 18.9609 14.5858 18.5858C14.9609 18.2107 15.4696 18 16 18ZM16 19C15.7348 19 15.4804 19.1054 15.2929 19.2929C15.1054 19.4804 15 19.7348 15 20C15 20.2652 15.1054 20.5196 15.2929 20.7071C15.4804 20.8946 15.7348 21 16 21C16.2652 21 16.5196 20.8946 16.7071 20.7071C16.8946 20.5196 17 20.2652 17 20C17 19.7348 16.8946 19.4804 16.7071 19.2929C16.5196 19.1054 16.2652 19 16 19ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 19.4696 5.21071 18.9609 5.58579 18.5858C5.96086 18.2107 6.46957 18 7 18ZM7 19C6.73478 19 6.48043 19.1054 6.29289 19.2929C6.10536 19.4804 6 19.7348 6 20C6 20.2652 6.10536 20.5196 6.29289 20.7071C6.48043 20.8946 6.73478 21 7 21C7.26522 21 7.51957 20.8946 7.70711 20.7071C7.89464 20.5196 8 20.2652 8 20C8 19.7348 7.89464 19.4804 7.70711 19.2929C7.51957 19.1054 7.26522 19 7 19ZM18 6H4.27L6.82 12H15C15.33 12 15.62 11.84 15.8 11.6L18.8 7.6C18.93 7.43 19 7.22 19 7C19 6.73478 18.8946 6.48043 18.7071 6.29289C18.5196 6.10536 18.2652 6 18 6ZM15 13H6.87L6.1 14.56L6 15C6 15.2652 6.10536 15.5196 6.29289 15.7071C6.48043 15.8946 6.73478 16 7 16H18V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C4.9997 14.6607 5.08573 14.3269 5.25 14.03L5.97 12.56L2.34 4H1V3H3L3.85 5H18C18.5304 5 19.0391 5.21071 19.4142 5.58579C19.7893 5.96086 20 6.46957 20 7C20 7.5 19.83 7.92 19.55 8.26L16.64 12.15C16.28 12.66 15.68 13 15 13Z" fill="black"></path>
                                </svg>
                            </span>
                            <div class="countBox position-absolute bg-black d-flex align-items-center justify-content-center -circle text-white text-center cart-count">0</div>
                        </a>
                        
                        <button class="toggle font-30 d-block d-lg-none outline-0 border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                            <i class="bi bi-list color-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center">
                <img src="https://herbandhouse.com/public/front/images/logo 1.jpg" alt="logo" width="40" height="40" class="me-2" />
                <h5 class="offcanvas-title mb-0" id="mobileMenuLabel">Menu</h5>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- User Profile Section (if logged in) -->
            @auth
                <div class="mobile-user-section p-3 border-bottom bg-light">
                    <div class="d-flex align-items-center mb-2">
                        <div class="user-avatar me-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </div>
            @endauth
            
            <!-- Navigation Menu -->
            <div class="mobile-nav-menu">
                <!-- Home -->
                <a href="{{ route('user.home') }}" class="mobile-nav-item d-flex align-items-center px-3 py-3 text-decoration-none text-dark border-bottom">
                    <i class="bi bi-house me-3 text-primary"></i>
                    <span>Home</span>
                </a>
                
                <!-- Categories Dropdown -->
                <div class="mobile-nav-dropdown">
                    <button class="mobile-nav-item d-flex align-items-center justify-content-between px-3 py-3 w-100 border-0 bg-transparent text-start text-dark border-bottom" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCategoriesCollapse" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-grid me-3 text-primary"></i>
                            <span>All Products</span>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="collapse" id="mobileCategoriesCollapse">
                        <div class="mobile-submenu bg-light">
                            @php
                                $categories = \App\Models\Category::orderBy('title')->get();
                            @endphp
                            @foreach($categories as $category)
                                <a href="{{ route('user.category', $category) }}" class="mobile-submenu-item d-block px-4 py-2 text-decoration-none text-dark">
                                    {{ $category->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Shop Now -->
                <a href="{{ route('user.home') }}" class="mobile-nav-item d-flex align-items-center px-3 py-3 text-decoration-none text-dark border-bottom">
                    <i class="bi bi-bag me-3 text-primary"></i>
                    <span>Shop Now</span>
                </a>
                
                <!-- Search -->
                <button class="mobile-nav-item d-flex align-items-center px-3 py-3 w-100 border-0 bg-transparent text-start text-dark border-bottom" data-bs-toggle="offcanvas" data-bs-target="#searchButton">
                    <i class="bi bi-search me-3 text-primary"></i>
                    <span>Search Products</span>
                </button>
                
                @auth
                    <!-- Wishlist -->
                    <a href="{{ route('user.wishlist') }}" class="mobile-nav-item d-flex align-items-center justify-content-between px-3 py-3 text-decoration-none text-dark border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-heart me-3 text-primary"></i>
                            <span>My Wishlist</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ auth()->user()->wishlists()->count() }}</span>
                    </a>
                    
                    <!-- Cart -->
                    <a href="{{ route('user.cart') }}" class="mobile-nav-item d-flex align-items-center justify-content-between px-3 py-3 text-decoration-none text-dark border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cart me-3 text-primary"></i>
                            <span>My Cart</span>
                        </div>
                        <span class="badge bg-primary rounded-pill cart-count">0</span>
                    </a>
                    
                    <!-- Profile Links -->
                    <a href="{{ route('user.profile') }}" class="mobile-nav-item d-flex align-items-center px-3 py-3 text-decoration-none text-dark border-bottom">
                        <i class="bi bi-person me-3 text-primary"></i>
                        <span>My Profile</span>
                    </a>
                    
                    <a href="{{ route('user.my-orders') }}" class="mobile-nav-item d-flex align-items-center px-3 py-3 text-decoration-none text-dark border-bottom">
                        <i class="bi bi-bag-check me-3 text-primary"></i>
                        <span>My Orders</span>
                    </a>
                    
                    <a href="{{ route('user.my-account') }}" class="mobile-nav-item d-flex align-items-center px-3 py-3 text-decoration-none text-dark border-bottom">
                        <i class="bi bi-gear me-3 text-primary"></i>
                        <span>Account Settings</span>
                    </a>
                    
                    <!-- Logout -->
                    <form action="{{ route('user.logout') }}" method="POST" class="border-bottom">
                        @csrf
                        <button type="submit" class="mobile-nav-item d-flex align-items-center px-3 py-3 w-100 border-0 bg-transparent text-start text-danger">
                            <i class="bi bi-box-arrow-right me-3"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <!-- Guest Actions -->
                    <button class="mobile-nav-item d-flex align-items-center px-3 py-3 w-100 border-0 bg-transparent text-start text-dark border-bottom" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="bi bi-heart me-3 text-primary"></i>
                        <span>Wishlist (Login Required)</span>
                    </button>
                    
                    <a href="{{ route('user.cart') }}" class="mobile-nav-item d-flex align-items-center justify-content-between px-3 py-3 text-decoration-none text-dark border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cart me-3 text-primary"></i>
                            <span>Cart</span>
                        </div>
                        <span class="badge bg-primary rounded-pill cart-count">0</span>
                    </a>
                    
                    <button class="mobile-nav-item d-flex align-items-center px-3 py-3 w-100 border-0 bg-transparent text-start text-primary border-bottom" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="bi bi-person-plus me-3"></i>
                        <span>Login / Register</span>
                    </button>
                @endauth
            </div>
            
            <!-- Contact Info -->
            <div class="mobile-contact-info p-3 mt-3">
                <h6 class="text-muted mb-3">Contact Us</h6>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-telephone me-2 text-muted"></i>
                    <a href="tel:+916376191966" class="text-decoration-none text-dark">+91 6376191966</a>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-envelope me-2 text-muted"></i>
                    <a href="mailto:theherbandhouse@gmail.com" class="text-decoration-none text-dark">theherbandhouse@gmail.com</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="searchButton">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Search Our Site</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body position-relative">
            <div class="search-wrapper-widget">
                <form action="{{ route('user.home') }}" method="get">
                    <!-- Category Dropdown -->
                    <div class="mb-4 inputBox">
                        <select class="form-select category-select" name="category" onchange="categoryfatch(this.value)" style="border-radius: 25px; padding: 12px 20px; border: 1px solid #ddd; font-size: 14px;">
                            <option selected disabled>All Categories</option>
                            @php
                                $categories = \App\Models\Category::orderBy('title')->get();
                            @endphp
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="mb-2 search-wrapper position-relative">
                        <input type="text" id="ProductSearch" class="form-control search-input" name="search" 
                               placeholder="Search Your Products..." onkeyup="SearchWrappar()" 
                               style="border-radius: 25px; padding: 12px 50px 12px 20px; border: 1px solid #ddd; font-size: 14px;" />
                        <button type="submit" class="search-button position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #666;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.098zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
                
                <div class="products-info-MainBox mt-4">
                    <div class="py-3 px-3 bg-light border-0 font-14 fw-medium text-muted" style="border-radius: 8px;">
                        Need some inspiration?
                    </div>
                    <div class="products-infoBox mt-3" id="productContainer">
                        <!-- Search results will be populated here -->
                    </div>
                </div>
                
                <!-- View All button at bottom -->
                <div class="py-3 px-4 bg-white border-top position-absolute bottom-0 start-0 w-100">
                    <a class="font-14 fw-medium d-flex align-items-center gap-1 text-black text-decoration-none" href="{{ route('user.home') }}">
                        View All
                        <span><i class="bi bi-arrow-right-circle-fill"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Auth Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered position-relative">
            <div class="modal-content p-0">
                <!-- Close Button -->
                <button style="top:15px; right:15px; z-index:12;" class="outline-0 border-0 bg-transparent position-absolute" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x font-26"></i>
                </button>
                
                <div class="modal-body p-0">
                    <div class="d-flex flex-lg-row flex-column align-items-center w-100">
                        <!-- IMAGE SECTION -->
                        <div class="col-lg-6 d-none d-lg-block p-0">
                            <div class="h-100 w-100">
                                <img src="https://herbandhouse.com/public/upload/banner/685b9b2fc3d95h5_cat2 1.jpg" class="w-100 h-100 object-fit-cover rounded-start" alt="Login Image" />
                            </div>
                        </div>
                        
                        <!-- FORM SECTION -->
                        <div class="col-lg-6 col-12 p-4">
                            <div class="login-signup-popup">
                                <!-- TABS -->
                                <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link px-4 active" data-bs-toggle="tab" data-bs-target="#v-pills-login" type="button" role="tab" id="v-pills-login-tab">
                                            Login
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link px-4" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                                            Register
                                        </button>
                                    </li>
                                </ul>
                                
                                <!-- TABS CONTENT -->
                                <div class="tab-content" id="productTabContent">
                                    <!-- LOGIN TAB -->
                                    <div class="tab-pane fade show active" id="v-pills-login" role="tabpanel">
                                        <form id="loginForm" action="{{ route('user.login.submit') }}" method="POST">
                                            @csrf
                                            <div class="alert alert-danger d-none" id="loginError"></div>
                                            <div class="alert alert-success d-none" id="loginSuccess"></div>
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="loginEmail">Email Address <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" id="loginEmail" name="email" value="{{ old('email') }}" placeholder="Enter your email" required />
                                                        <div class="invalid-feedback" id="loginEmailError"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="loginPassword">Password <span class="text-danger">*</span></label>
                                                        <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                            <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" id="loginPassword" name="password" placeholder="Enter your password" required />
                                                            <span class="p-2 toggle-password-btn" type="button">
                                                                <i class="bi bi-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="loginPasswordError"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="themeButton2 mt-2" id="loginBtn">
                                                <span class="btn-text">Login</span>
                                                <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- REGISTER TAB -->
                                    <div class="tab-pane fade" id="register" role="tabpanel">
                                        <form id="registerForm" action="{{ route('user.register.submit') }}" method="POST">
                                            @csrf
                                            <div class="alert alert-danger d-none" id="registerError"></div>
                                            <div class="alert alert-success d-none" id="registerSuccess"></div>
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="regName">Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="regName" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required />
                                                        <div class="invalid-feedback" id="regNameError"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="regEmail">Email Address <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" id="regEmail" value="{{ old('email') }}" name="email" placeholder="Enter your email" required />
                                                        <div class="invalid-feedback" id="regEmailError"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="regPassword">Password <span class="text-danger">*</span></label>
                                                        <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                            <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" id="regPassword" name="password" placeholder="Create a password" required />
                                                            <span class="p-2 toggle-password-btn" type="button">
                                                                <i class="bi bi-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="regPasswordError"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="inputBox">
                                                        <label for="regPasswordConfirm">Confirm Password <span class="text-danger">*</span></label>
                                                        <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                            <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" id="regPasswordConfirm" name="password_confirmation" placeholder="Confirm your password" required />
                                                            <span class="p-2 toggle-password-btn" type="button">
                                                                <i class="bi bi-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="regPasswordConfirmError"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="themeButton2 mt-2" id="registerBtn">
                                                <span class="btn-text">Register</span>
                                                <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 mb-4 mb-lg-0 col-12">
                    <img class="mb-4" width="100px" src="https://herbandhouse.com/public/front/images/logo 1.jpg" alt="" />
                    <div class="footer-info font-14 mb-3">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            <span>herbnhouse,</span>
                        </div>
                        <a class="d-flex align-items-center gap-1 text-black" href="tel:+916376191966">
                            <i class="bi bi-telephone"></i> +91 6376191966
                        </a>
                        <a class="d-flex align-items-center gap-1 text-black" href="mailto:theherbandhouse@gmail.com">
                            <i class="bi bi-envelope"></i> theherbandhouse@gmail.com
                        </a>
                    </div>
                    <div class="footer-socialIcons">
                        <ul class="d-flex align-items-center gap-4">
                            <li>
                                <a href="https://www.instagram.com/" target="_blank"><i class="bi bi-instagram font-20"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('user.home') }}" target="_blank"><i class="bi bi-whatsapp font-20"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('user.home') }}" target="_blank"><i class="bi bi-twitter font-20"></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/proftcode1" target="_blank"><i class="bi bi-facebook font-20"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0 col-6">
                    <h3 class="font-18 fw-medium mb-3" style="color: var(--color3)">Categories</h3>
                    <ul>
                        <li class="mb-2"><a href="{{ route('user.home') }}" style="color: var(--color3); text-decoration: none;">All Products</a></li>
                        <li class="mb-2"><a href="{{ route('user.home') }}" style="color: var(--color3); text-decoration: none;">Show Now</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0 col-6">
                    <h3 class="font-18 fw-medium mb-3" style="color: var(--color3)">Information</h3>
                    <ul>
                        <li class="mb-2"><a href="{{ route('user.about-us') }}" style="color: var(--color3); text-decoration: none;">About us</a></li>
                        <li class="mb-2"><a href="{{ route('user.privacy-policy') }}" style="color: var(--color3); text-decoration: none;">Privacy Policy</a></li>
                        <li class="mb-2"><a href="{{ route('user.terms-conditions') }}" style="color: var(--color3); text-decoration: none;">Terms & Conditions</a></li>
                        <li class="mb-2"><a href="{{ route('user.shipping-policy') }}" style="color: var(--color3); text-decoration: none;">Shipping Policy</a></li>
                        <li class="mb-2"><a href="{{ route('user.return-policy') }}" style="color: var(--color3); text-decoration: none;">Return Policy</a></li>
                        <li class="mb-2"><a href="{{ route('user.refund-cancellation') }}" style="color: var(--color3); text-decoration: none;">Refund and Cancellation Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0 col-6">
                    <h3 class="font-18 fw-medium mb-3" style="color: var(--color3)">Useful Links</h3>
                    <ul>
                        @auth
                            <li class="mb-2"><a href="{{ route('user.my-account') }}" style="color: var(--color3); text-decoration: none;">my account</a></li>
                            <li class="mb-2"><a href="{{ route('user.my-orders') }}" style="color: var(--color3); text-decoration: none;">My Order</a></li>
                        @else
                            <li class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="color: var(--color3); text-decoration: none;">my account</a></li>
                            <li class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="color: var(--color3); text-decoration: none;">My Order</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <h3 class="font-18 fw-medium mb-3">Newsletter Sign up</h3>
                    <p style="color: var(--color3)" class="font-14 mb-4">
                        Stay updated with our latest news, offers, and insights.
                    </p>
                    <form action="{{ route('user.home') }}" method="post">
                        @csrf
                        <div class="inputBox-container p-1 d-flex align-items-center justify-content-between gap-2">
                            <div class="inputBox">
                                <input type="email" class="form-control" name="email" required id="email" placeholder="Enter your email" />
                            </div>
                            <button type="submit" class="submit-btn">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>
    
    <div class="ft-bottom py-3 font-14 text-center text-white">
        Copyright © {{ date('Y') }}-HerbnHouse, Inc. All rights reserved.
    </div>

    <!-- jquery script -->
    <script src="https://herbandhouse.com/public/front/js/jquery-3.6.0.min.js"></script>
    <!-- bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <!-- owljs js -->
    <script src="https://herbandhouse.com/public/front/js/owl.carousel.js"></script>
    <!-- custom js -->
    <!-- <script src="https://herbandhouse.com/public/front/js/custom.js"></script> -->
    
    <!--================== Password Show and Hide =========================-->
    <script>
        document.querySelectorAll('.toggle-password-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = this.closest('.password-wrapper').querySelector('.toggle-password-input');
                const icon = this.querySelector('i');
                const isPassword = input.type === 'password';
                
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
    
    <!--================== AJAX Form Handling =========================-->
    <script>
        // Login Form AJAX
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const btn = $('#loginBtn');
            const btnText = btn.find('.btn-text');
            const spinner = btn.find('.spinner-border');
            
            // Clear previous errors
            $('.invalid-feedback').hide().text('');
            $('.form-control').removeClass('is-invalid');
            $('#loginError, #loginSuccess').addClass('d-none');
            
            // Show loading state
            btn.prop('disabled', true);
            btnText.text('Signing in...');
            spinner.removeClass('d-none');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#loginSuccess').removeClass('d-none').text(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON;
                    
                    if (errors.message) {
                        $('#loginError').removeClass('d-none').text(errors.message);
                    }
                    
                    if (errors.errors) {
                        $.each(errors.errors, function(field, messages) {
                            const input = $('#login' + field.charAt(0).toUpperCase() + field.slice(1));
                            const errorDiv = $('#login' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
                            
                            input.addClass('is-invalid');
                            errorDiv.show().text(messages[0]);
                        });
                    }
                },
                complete: function() {
                    // Reset button state
                    btn.prop('disabled', false);
                    btnText.text('Login');
                    spinner.addClass('d-none');
                }
            });
        });
        
        // Register Form AJAX
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const btn = $('#registerBtn');
            const btnText = btn.find('.btn-text');
            const spinner = btn.find('.spinner-border');
            
            // Clear previous errors
            $('.invalid-feedback').hide().text('');
            $('.form-control').removeClass('is-invalid');
            $('#registerError, #registerSuccess').addClass('d-none');
            
            // Show loading state
            btn.prop('disabled', true);
            btnText.text('Creating account...');
            spinner.removeClass('d-none');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#registerSuccess').removeClass('d-none').text(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON;
                    
                    if (errors.message) {
                        $('#registerError').removeClass('d-none').text(errors.message);
                    }
                    
                    if (errors.errors) {
                        $.each(errors.errors, function(field, messages) {
                            let input, errorDiv;
                            
                            if (field === 'name') {
                                input = $('#regName');
                                errorDiv = $('#regNameError');
                            } else if (field === 'email') {
                                input = $('#regEmail');
                                errorDiv = $('#regEmailError');
                            } else if (field === 'password') {
                                input = $('#regPassword');
                                errorDiv = $('#regPasswordError');
                            } else if (field === 'password_confirmation') {
                                input = $('#regPasswordConfirm');
                                errorDiv = $('#regPasswordConfirmError');
                            }
                            
                            if (input && errorDiv) {
                                input.addClass('is-invalid');
                                errorDiv.show().text(messages[0]);
                            }
                        });
                    }
                },
                complete: function() {
                    // Reset button state
                    btn.prop('disabled', false);
                    btnText.text('Register');
                    spinner.addClass('d-none');
                }
            });
        });
    </script>
    
    <!--================== Drop Down Hover ==========================================-->
    <script>
        function toggleDropdown(iconEl) {
            if (window.innerWidth < 992) {
                const menuItem = iconEl.closest('.dropMenu');
                // Close all other open dropdowns
                document.querySelectorAll('.dropMenu').forEach(el => {
                    if (el !== menuItem) el.classList.remove('show-dropdown');
                });
                // Toggle current
                menuItem.classList.toggle('show-dropdown');
            }
        }
        
        // Close dropdown on outside click (only on mobile)
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 992 && !e.target.closest('.dropMenu')) {
                document.querySelectorAll('.dropMenu').forEach(el => {
                    el.classList.remove('show-dropdown');
                });
            }
        });
        
        // Search functionality
        function categoryfatch(id) {
            var base_url = "{{ route('user.ajax.search') }}";
            $.ajax({
                url: base_url,
                type: "get",
                data: {
                    category: id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var products = response.data;
                        let html = '';
                        products.forEach(function(product) {
                            html += `<div class="serch-info-products d-flex align-items-center gap-2">
                                <a class="search-imgBox" href="{{ route('user.home') }}/product/${product.slug}">
                                    <img src="{{ asset('storage') }}/${product.image}" alt="" />
                                </a>
                                <a href="{{ route('user.home') }}/product/${product.slug}">
                                    <h4 class="line-clamp font-14 fw-medium text-black transitionBox">
                                        ${product.title}
                                    </h4>
                                </a>
                            </div>`;
                        });
                        $('#productContainer').html(html);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }
        
        function SearchWrappar() {
            var ProductSearch = $('#ProductSearch').val();
            var base_url = "{{ route('user.ajax.search') }}";
            $.ajax({
                url: base_url,
                type: "get",
                data: {
                    search: ProductSearch
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var products = response.data;
                        let html = '';
                        products.forEach(function(product) {
                            html += `<div class="serch-info-products d-flex align-items-center gap-2">
                                <a class="search-imgBox" href="{{ route('user.home') }}/product/${product.slug}">
                                    <img src="{{ asset('storage') }}/${product.image}" alt="" />
                                </a>
                                <a href="{{ route('user.home') }}/product/${product.slug}">
                                    <h4 class="line-clamp font-14 fw-medium text-black transitionBox">
                                        ${product.title}
                                    </h4>
                                </a>
                            </div>`;
                        });
                        $('#productContainer').html(html);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }
    </script>
    
    <!-- Cart Count Update Script -->
    <script>
        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
        
        function updateCartCount() {
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
        
        // Wishlist functionality for product cards
        function toggleWishlistFromCard(productId) {
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
                    
                    if (data.action === 'added') {
                        icon.className = 'fas fa-heart';
                        showToast('Added to wishlist!', 'success');
                    } else {
                        icon.className = 'far fa-heart';
                        showToast('Removed from wishlist!', 'success');
                    }
                    
                    // Update wishlist count in header
                    updateWishlistCount(data.wishlist_count);
                } else {
                    showToast(data.message || 'Failed to update wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
            });
        }
        
        function updateWishlistCount(count) {
            const wishlistCountElements = document.querySelectorAll('.wishlist-count');
            wishlistCountElements.forEach(element => {
                element.textContent = count || 0;
            });
        }
        
        function showLoginModal() {
            showToast('Please login to add items to your wishlist', 'info');
        }
        
        function showToast(message, type = 'info') {
            // Simple toast notification
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
        
        // Mobile Menu Enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Close mobile menu when clicking on a link (except dropdown toggles)
            const mobileMenuLinks = document.querySelectorAll('#mobileMenu .mobile-nav-item:not([data-bs-toggle])');
            const mobileMenu = document.getElementById('mobileMenu');
            
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Close the offcanvas menu
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(mobileMenu);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                });
            });
            
            // Handle dropdown arrow rotation
            const dropdownToggles = document.querySelectorAll('#mobileMenu [data-bs-toggle="collapse"]');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const chevron = this.querySelector('.bi-chevron-down');
                    if (chevron) {
                        // Toggle the rotation class
                        setTimeout(() => {
                            const isExpanded = this.getAttribute('aria-expanded') === 'true';
                            chevron.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(-90deg)';
                        }, 10);
                    }
                });
            });
            
            // Update mobile menu cart and wishlist counts
            function updateMobileCounts() {
                // Update cart count in mobile menu
                updateCartCount();
                
                // Update wishlist count in mobile menu (for authenticated users)
                @auth
                    const wishlistCount = {{ auth()->user()->wishlists()->count() }};
                    const mobileWishlistBadge = document.querySelector('#mobileMenu .badge');
                    if (mobileWishlistBadge) {
                        mobileWishlistBadge.textContent = wishlistCount;
                    }
                @endauth
            }
            
            // Call update function
            updateMobileCounts();
            
            // Handle mobile menu search button
            const mobileSearchBtn = document.querySelector('#mobileMenu [data-bs-target="#searchButton"]');
            if (mobileSearchBtn) {
                mobileSearchBtn.addEventListener('click', function() {
                    // Close mobile menu first
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(mobileMenu);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                });
            }
            
            // Sticky Header Functionality
            const header = document.getElementById('header');
            const headerBottom = document.querySelector('.header-bottom');
            const body = document.body;
            let fullHeaderHeight = 0;
            let stickyHeaderHeight = 0;
            let isSticky = false;
            
            function updateHeaderHeights() {
                // Full header height (all sections)
                fullHeaderHeight = header.offsetHeight;
                // Sticky header height (only header-bottom)
                stickyHeaderHeight = headerBottom.offsetHeight;
            }
            
            function handleScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100 && !isSticky) {
                    // Make header sticky (hide top and middle sections)
                    header.classList.add('sticky');
                    body.classList.add('header-sticky');
                    body.style.paddingTop = stickyHeaderHeight + 'px';
                    isSticky = true;
                } else if (scrollTop <= 100 && isSticky) {
                    // Remove sticky header (show all sections)
                    header.classList.remove('sticky');
                    body.classList.remove('header-sticky');
                    body.style.paddingTop = '0';
                    isSticky = false;
                }
            }
            
            // Initialize header heights
            updateHeaderHeights();
            
            // Add scroll event listener
            window.addEventListener('scroll', handleScroll);
            
            // Update header heights on window resize
            window.addEventListener('resize', function() {
                updateHeaderHeights();
                if (isSticky) {
                    body.style.paddingTop = stickyHeaderHeight + 'px';
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
