<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - HerbnHouse')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <style>
        :root {
            /* HomeArt Clean Theme Colors */
            --primary-green: #10B981;
            --light-green: #34D399;
            --soft-green: #6EE7B7;
            --mint-green: #A7F3D0;
            --pale-green: #D1FAE5;
            --background-white: #FFFFFF;
            --background-light: #FAFAFA;
            --background-soft: #F9FAFB;
            --text-primary: #1F2937;
            --text-secondary: #4B5563;
            --text-muted: #9CA3AF;
            --text-light: #D1D5DB;
            --border-light: #E5E7EB;
            --border-soft: #F3F4F6;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
            --sidebar-width: 280px;
            --shadow-soft: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background-white);
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
            line-height: 1.6;
            font-weight: 400;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(52, 211, 153, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(167, 243, 208, 0.01) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        /* Clean Animated Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--pale-green) 0%, var(--mint-green) 50%, var(--soft-green) 100%);
            border-right: 1px solid var(--border-light);
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: var(--shadow-large);
            animation: sidebarGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes sidebarGlow {
            0% {
                background: linear-gradient(180deg, var(--pale-green) 0%, var(--mint-green) 50%, var(--soft-green) 100%);
                box-shadow: var(--shadow-large);
            }
            100% {
                background: linear-gradient(180deg, var(--mint-green) 0%, var(--soft-green) 50%, var(--light-green) 100%);
                box-shadow: 0 10px 25px -3px rgba(16, 185, 129, 0.15), 0 4px 6px -2px rgba(16, 185, 129, 0.1);
            }
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.15);
            margin: 1rem;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.8s ease;
        }
        
        .sidebar-header:hover::before {
            transform: translateX(100%);
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
            letter-spacing: -0.025em;
            position: relative;
            z-index: 2;
        }
        
        .sidebar-brand:hover {
            color: var(--primary-green);
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        
        .sidebar-brand .crown-icon {
            color: var(--primary-green);
            margin-right: 0.75rem;
            font-size: 1.75rem;
            filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
            animation: leafFloat 2s ease-in-out infinite alternate;
        }
        
        @keyframes leafFloat {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-3px) rotate(2deg); }
        }
        
        .sidebar-nav {
            padding: 1.5rem 0;
        }
        
        .nav-section {
            margin-bottom: 2.5rem;
        }
        
        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 1.5rem 0.75rem;
            margin-bottom: 0.75rem;
            position: relative;
            opacity: 0.8;
        }
        
        .nav-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1.5rem;
            width: 2rem;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-green), transparent);
            border-radius: 1px;
        }
        
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            margin: 0.25rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            margin-right: 1rem;
            font-size: 1.1rem;
            position: relative;
            z-index: 2;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--text-primary);
            transform: translateX(4px) scale(1.01);
            box-shadow: var(--shadow-medium);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .sidebar .nav-link:hover::before {
            left: 0;
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.4);
            color: var(--text-primary);
            box-shadow: var(--shadow-medium);
            border: 1px solid rgba(255, 255, 255, 0.4);
            font-weight: 600;
        }
        
        .sidebar .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--primary-green);
            border-radius: 0 2px 2px 0;
            z-index: 3;
        }
        
        /* Clean Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--background-white);
        }
        
        .top-navbar {
            background: var(--background-white);
            border-bottom: 1px solid var(--border-light);
            padding: 1.5rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--shadow-soft);
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            position: relative;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green));
            border-radius: 2px;
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .notification-btn {
            position: relative;
            background: var(--background-soft);
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            font-size: 1.125rem;
            padding: 0.75rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .notification-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-green);
        }
        
        .notification-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 8px;
            height: 8px;
            background: var(--danger-color);
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--background-soft);
            border: 1px solid var(--border-light);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: var(--text-primary);
            font-weight: 500;
            cursor: pointer;
        }
        
        .user-btn:hover {
            background: var(--background-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-green);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid var(--light-green);
            box-shadow: var(--shadow-soft);
        }
        
        .main-content {
            padding: 2rem;
            background: var(--background-white);
        }
        
        /* Clean Modern Cards */
        .card {
            background: var(--background-white);
            border: 1px solid var(--border-light);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green), var(--soft-green));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-large);
            border-color: var(--primary-green);
        }
        
        .card:hover::before {
            opacity: 1;
        }
        
        .card-header {
            background: var(--background-soft);
            border-bottom: 1px solid var(--border-light);
            padding: 1.5rem;
            border-radius: 16px 16px 0 0 !important;
            position: relative;
        }
        
        .card-body {
            padding: 1.5rem;
            color: var(--text-primary);
        }
        
        /* Clean Modern Buttons */
        .btn {
            font-weight: 500;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: var(--primary-green);
            color: white;
            border: 1px solid var(--primary-green);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
            background: var(--light-green);
            border-color: var(--light-green);
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #047857);
            color: white;
            border: 1px solid var(--success-color);
        }
        
        .btn-success:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: var(--darker-color);
            border: 1px solid var(--warning-color);
        }
        
        .btn-warning:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            color: var(--darker-color);
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #0e7490);
            color: white;
            border: 1px solid var(--info-color);
        }
        
        .btn-info:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #b91c1c);
            color: white;
            border: 1px solid var(--danger-color);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
            color: white;
        }
        
        /* Clean Modern Alerts */
        .alert {
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: currentColor;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.05);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.05);
            color: var(--danger-color);
            border-color: rgba(239, 68, 68, 0.2);
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: var(--background-soft);
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            font-size: 1.25rem;
            padding: 0.75rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .mobile-menu-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-green);
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                z-index: 1001;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .top-navbar {
                padding: 1rem 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .navbar-actions {
                gap: 1rem;
            }
            
            .user-info {
                display: none;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .top-navbar {
                padding: 0.75rem 1rem;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
            
            .navbar-actions {
                gap: 0.75rem;
            }
            
            .notification-btn {
                padding: 0.5rem;
                font-size: 1rem;
            }
            
            .user-btn {
                padding: 0.25rem 0.5rem;
            }
            
            .main-content {
                padding: 0.75rem;
            }
        }
        
        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 2px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- Modern Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-leaf crown-icon"></i>
                <span>HerbnHouse Admin</span>
            </a>
            <!-- Mobile Close Button -->
            <button class="mobile-close-btn d-lg-none" id="mobileCloseBtn" style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: var(--text-primary); padding: 0.5rem; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-seedling"></i>
                    <span>Main Dashboard</span>
                </a>
            </div>
            
            {{-- <div class="nav-section">
                <div class="nav-section-title">Content Management</div>
                <a href="{{ route('admin.cms.index') }}" class="nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>CMS Content</span>
                </a>
                <a href="{{ route('admin.cms.create') }}" class="nav-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Create Content</span>
                </a>
            </div> --}}
            
            
            <div class="nav-section">
                <div class="nav-section-title">Inventory Management</div>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-leaf"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.shops.index') }}" class="nav-link {{ request()->routeIs('admin.shops.*') ? 'active' : '' }}">
                    <i class="fas fa-store"></i>
                    <span>Shops</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Orders</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">User Management</div>
                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Admin Management</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Permissions</span>
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Tools</div>
                <a href="{{ route('user.home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>View Website</span>
                </a>
            </div>
            
        </div>
    </div>
    
    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navigation -->
        <div class="top-navbar">
            <div class="navbar-content">
                <div class="d-flex align-items-center">
                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-btn me-3" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title mb-0">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="navbar-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <div class="notification-badge"></div>
                    </button>
                    
                    <div class="user-dropdown dropdown">
                        <button class="user-btn" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                                <div class="user-role" style="font-size: 0.8rem; color: var(--primary-green); font-weight: 600;">Administrator</div>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 0.75rem; color: var(--text-muted);"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile Menu Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileCloseBtn = document.getElementById('mobileCloseBtn');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            // Open mobile menu
            mobileMenuBtn?.addEventListener('click', function() {
                sidebar.classList.add('mobile-open');
                mobileOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            // Close mobile menu
            function closeMobileMenu() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            mobileCloseBtn?.addEventListener('click', closeMobileMenu);
            mobileOverlay?.addEventListener('click', closeMobileMenu);
            
            // Close menu on navigation link click
            const navLinks = sidebar?.querySelectorAll('.nav-link');
            navLinks?.forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(closeMobileMenu, 100);
                });
            });
            
            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                    closeMobileMenu();
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
    
    @yield('scripts')
</body>
</html>
