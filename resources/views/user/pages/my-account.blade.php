@extends('user.layout')

@section('title', 'My Account - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </div>
    </nav>

    <!-- My Account Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <div class="text-center mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-user text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active d-flex align-items-center py-2" href="{{ route('user.my-account') }}">
                            <i class="fas fa-user me-2"></i> Account Overview
                        </a>
                        <a class="nav-link d-flex align-items-center py-2" href="{{ route('user.my-orders') }}">
                            <i class="fas fa-shopping-bag me-2"></i> My Orders
                        </a>
                        <a class="nav-link d-flex align-items-center py-2" href="{{ route('user.profile') }}">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                        <a class="nav-link d-flex align-items-center py-2" href="{{ route('user.wishlist') }}">
                            <i class="fas fa-heart me-2"></i> Wishlist
                        </a>
                        <a class="nav-link d-flex align-items-center py-2" href="{{ route('user.addresses') }}">
                            <i class="fas fa-map-marker-alt me-2"></i> Addresses
                        </a>
                        <hr>
                        <a class="nav-link d-flex align-items-center py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </nav>
                    
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Welcome Section -->
                <div class="bg-white border rounded-3 p-4 shadow-sm mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">Welcome back, {{ $user->name }}!</h2>
                    <p class="text-muted mb-0">Manage your account, track orders, and explore our herbal products.</p>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $recentOrders->count() }}</h4>
                            <p class="text-muted small mb-0">Total Orders</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-heart text-success fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">0</h4>
                            <p class="text-muted small mb-0">Wishlist Items</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-star text-warning fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">0</h4>
                            <p class="text-muted small mb-0">Reviews Given</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white border rounded-3 p-4 shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 fw-bold mb-0">Recent Orders</h3>
                        <a href="{{ route('user.my-orders') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="fw-bold">#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('user.order.details', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag text-muted fs-1 mb-3"></i>
                            <h5 class="text-muted">No orders yet</h5>
                            <p class="text-muted">Start shopping to see your orders here</p>
                            <a href="{{ route('user.home') }}" class="btn btn-primary">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <h3 class="h5 fw-bold mb-3">Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.profile') }}" class="d-flex align-items-center p-3 border rounded text-decoration-none hover-bg-light">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-edit text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Update Profile</h6>
                                    <p class="text-muted small mb-0">Edit your personal information</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.addresses') }}" class="d-flex align-items-center p-3 border rounded text-decoration-none hover-bg-light">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Manage Addresses</h6>
                                    <p class="text-muted small mb-0">Add or edit delivery addresses</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.wishlist') }}" class="d-flex align-items-center p-3 border rounded text-decoration-none hover-bg-light">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-heart text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">My Wishlist</h6>
                                    <p class="text-muted small mb-0">View saved products</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.support') }}" class="d-flex align-items-center p-3 border rounded text-decoration-none hover-bg-light">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-headset text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">User Support</h6>
                                    <p class="text-muted small mb-0">Get help with your orders</p>
                                </div>
                            </a>
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

.text-success {
    color: #8B4513 !important;
}

.bg-success {
    background-color: #8B4513 !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.nav-link {
    color: #6c757d;
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
}

.nav-link:hover, .nav-link.active {
    background-color: #f8f9fa;
    color: #8B4513 !important;
}

.hover-bg-light:hover {
    background-color: #f8f9fa !important;
}

.btn-outline-primary {
    border-color: #8B4513;
    color: #8B4513;
}

.btn-outline-primary:hover {
    background-color: #8B4513;
    border-color: #8B4513;
}

.btn-primary {
    background-color: #8B4513;
    border-color: #8B4513;
}

.btn-primary:hover {
    background-color: #6d3410;
    border-color: #6d3410;
}
</style>
@endsection
