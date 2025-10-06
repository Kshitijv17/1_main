<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Panel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style type="text/tailwindcss">
        :root {
            --background-light: #F5F7F0;
            --background-dark: #2D3748;
            --card-light: #FFFFFF;
            --card-dark: #4A5568;
            --text-light: #4A5568;
            --text-dark: #E2E8F0;
            --heading-light: #2D3748;
            --heading-dark: #F7FAFC;
            --border-light: #E2E8F0;
            --border-dark: #4A5568;
            --accent-light: #68D391;
            --accent-dark: #9AE6B4;
            --primary: #F0FFF4;
            --sidebar-bg: #68D391;
            --sidebar-active: #48BB78;
        }
        .font-display {
            font-family: 'Montserrat', sans-serif;
        }
        .font-serif {
            font-family: 'Lora', serif;
        }
        body {
            background-color: var(--background-light);
            background-image: url("{{ asset('herb_bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .dark body {
            background-color: var(--background-dark);
            background-image: url("{{ asset('herb_bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 300,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>
</head>
<body class="font-display bg-gray-50 text-gray-700">
<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

<div class="flex h-screen">
    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[var(--sidebar-bg)] text-white flex flex-col shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
        <div class="h-16 flex items-center justify-between px-4 border-b border-white border-opacity-20">
            <div class="flex items-center">
            @if(auth()->user()->shop && auth()->user()->shop->logo)
                <img src="{{ asset('storage/' . auth()->user()->shop->logo) }}" alt="Shop Logo" class="w-8 h-8 rounded-full mr-2">
            @else
                <span class="material-symbols-outlined text-3xl text-white mr-2">eco</span>
            @endif
                <h1 class="text-lg font-serif font-bold text-white ml-2">
                    {{ auth()->user()->shop->name ?? 'HerbDash' }}
                </h1>
            </div>
            <button id="close-mobile-menu" class="lg:hidden p-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                <span class="material-symbols-outlined text-white">close</span>
            </button>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.dashboard') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.dashboard') }}">
                <span class="material-symbols-outlined mr-3 text-lg">dashboard</span> Dashboard
            </a>
            
            @if(!auth()->user()->shop)
                <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.shop.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.shop.create') }}">
                    <span class="material-symbols-outlined mr-3 text-lg">add_business</span> Setup Shop
                </a>
            @else
                <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.shop.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.shop.edit') }}">
                    <span class="material-symbols-outlined mr-3 text-lg">spa</span> Manage Shop
                </a>
            @endif
            
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.products.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.products.index') }}">
                <span class="material-symbols-outlined mr-3 text-lg">grass</span> Products
            </a>
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.orders.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.orders.index') }}">
                <span class="material-symbols-outlined mr-3 text-lg">receipt_long</span> Orders
            </a>
        </nav>
        
        <div class="p-4 border-t border-white border-opacity-20">
            <form action="{{ route('vendor.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-red-500 hover:bg-opacity-20 w-full text-left transition-all duration-200">
                    <span class="material-symbols-outlined mr-3 text-lg">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Desktop Sidebar -->
    <aside class="hidden lg:flex w-64 flex-shrink-0 bg-[var(--sidebar-bg)] text-white flex-col shadow-lg">
        <div class="h-16 flex items-center justify-center border-b border-white border-opacity-20">
            @if(auth()->user()->shop && auth()->user()->shop->logo)
                <img src="{{ asset('storage/' . auth()->user()->shop->logo) }}" alt="Shop Logo" class="w-8 h-8 rounded-full mr-2">
            @else
                <span class="material-symbols-outlined text-3xl text-white mr-2">eco</span>
            @endif
            <h1 class="text-xl font-serif font-bold text-white">
                {{ auth()->user()->shop->name ?? 'HerbDash' }}
            </h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.dashboard') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.dashboard') }}">
                <span class="material-symbols-outlined mr-3 text-lg">dashboard</span> Dashboard
            </a>
            
            @if(!auth()->user()->shop)
                <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.shop.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.shop.create') }}">
                    <span class="material-symbols-outlined mr-3 text-lg">add_business</span> Setup Shop
                </a>
            @else
                <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.shop.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.shop.edit') }}">
                    <span class="material-symbols-outlined mr-3 text-lg">spa</span> Manage Shop
                </a>
            @endif
            
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.products.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.products.index') }}">
                <span class="material-symbols-outlined mr-3 text-lg">grass</span> Products
            </a>
            <a class="flex items-center px-4 py-3 rounded-lg text-white {{ request()->routeIs('vendor.orders.*') ? 'bg-[var(--sidebar-active)] bg-opacity-80' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200" href="{{ route('vendor.orders.index') }}">
                <span class="material-symbols-outlined mr-3 text-lg">receipt_long</span> Orders
            </a>
        </nav>
        
        <div class="p-4 border-t border-white border-opacity-20">
            <form action="{{ route('vendor.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-red-500 hover:bg-opacity-20 w-full text-left transition-all duration-200">
                    <span class="material-symbols-outlined mr-3 text-lg">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 shadow-sm">
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <span class="material-symbols-outlined text-gray-600">menu</span>
            </button>
            <div class="flex items-center flex-1 lg:flex-initial">
                <h2 class="text-lg lg:text-2xl font-semibold text-gray-900 ml-2 lg:ml-0">@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-2 lg:space-x-4">
                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200 hidden sm:block">
                    <span class="material-symbols-outlined text-gray-600">notifications</span>
                </button>
                <div class="flex items-center space-x-2 lg:space-x-3">
                    @if(auth()->user()->shop && auth()->user()->shop->logo)
                        <img alt="Shop avatar" class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[var(--accent-light)]" src="{{ asset('storage/' . auth()->user()->shop->logo) }}">
                    @else
                        <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[var(--accent-light)] bg-[var(--accent-light)] flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-sm">person</span>
                        </div>
                    @endif
                    <div class="hidden sm:block">
                        <p class="font-semibold text-gray-900 text-sm lg:text-base">{{ auth()->user()->name }}</p>
                        <p class="text-xs lg:text-sm text-gray-600">Vendor</p>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="flex-1 p-4 lg:p-8 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="material-symbols-outlined inline mr-2">check_circle</span>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="material-symbols-outlined inline mr-2">error</span>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script>
// Mobile Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');
    
    // Open mobile menu
    mobileMenuBtn?.addEventListener('click', function() {
        mobileSidebar.classList.remove('-translate-x-full');
        mobileOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
    
    // Close mobile menu
    function closeMobileMenuFunc() {
        mobileSidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    closeMobileMenu?.addEventListener('click', closeMobileMenuFunc);
    mobileOverlay?.addEventListener('click', closeMobileMenuFunc);
    
    // Close menu on navigation link click
    const mobileNavLinks = mobileSidebar?.querySelectorAll('a');
    mobileNavLinks?.forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(closeMobileMenuFunc, 100);
        });
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileOverlay.classList.contains('hidden')) {
            closeMobileMenuFunc();
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(function(alert) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});
</script>

@yield('scripts')
@stack('scripts')
</body>
</html>
