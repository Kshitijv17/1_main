@extends('user.layout')

@section('title', 'My Orders - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.my-account') }}" class="text-decoration-none">My Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </div>
    </nav>

    <!-- My Orders Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <div class="text-center mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-user text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link d-flex align-items-center py-2" href="{{ route('user.my-account') }}">
                            <i class="fas fa-user me-2"></i> Account Overview
                        </a>
                        <a class="nav-link active d-flex align-items-center py-2" href="{{ route('user.my-orders') }}">
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
                <!-- Page Header -->
                <div class="bg-white border rounded-3 p-4 shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="h4 fw-bold text-dark mb-1">My Orders</h2>
                            <p class="text-muted mb-0">Track and manage your orders</p>
                        </div>
                        <div>
                            <a href="{{ route('user.home') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Filters -->
                <div class="bg-white border rounded-3 p-4 shadow-sm mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="orderFilter" id="all" checked>
                                <label class="btn btn-outline-primary" for="all">All Orders</label>

                                <input type="radio" class="btn-check" name="orderFilter" id="pending">
                                <label class="btn btn-outline-primary" for="pending">Pending</label>

                                <input type="radio" class="btn-check" name="orderFilter" id="delivered">
                                <label class="btn btn-outline-primary" for="delivered">Delivered</label>

                                <input type="radio" class="btn-check" name="orderFilter" id="cancelled">
                                <label class="btn btn-outline-primary" for="cancelled">Cancelled</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search orders..." id="orderSearch">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="bg-white border rounded-3 shadow-sm">
                    @if(isset($orders) && $orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="fas fa-shopping-bag text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Order #{{ $order->id }}</h5>
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-calendar me-1"></i>
                                                Placed on {{ $order->created_at->format('M d, Y') }}
                                            </p>
                                            <p class="text-muted small mb-2">
                                                <i class="fas fa-box me-1"></i>
                                                {{ $order->items->count() }} item(s)
                                            </p>
                                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <h5 class="fw-bold mb-2">₹{{ number_format($order->total_amount, 2) }}</h5>
                                    <div class="btn-group-vertical btn-group-sm">
                                        <a href="{{ route('user.order.details', $order) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </a>
                                        @if($order->status === 'pending')
                                        <button class="btn btn-outline-danger" onclick="cancelOrder({{ $order->id }})">
                                            <i class="fas fa-times me-1"></i>Cancel Order
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="p-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No orders found</h4>
                            <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                            <a href="{{ route('user.home') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Order Summary Stats -->
                @if(isset($orders) && $orders->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-primary fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $orders->total() }}</h4>
                            <p class="text-muted small mb-0">Total Orders</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $orders->where('status', 'delivered')->count() }}</h4>
                            <p class="text-muted small mb-0">Delivered</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-white border rounded-3 p-4 shadow-sm text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-warning fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $orders->where('status', 'pending')->count() }}</h4>
                            <p class="text-muted small mb-0">Pending</p>
                        </div>
                    </div>
                </div>
                @endif
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

.btn-outline-primary {
    border-color: #8B4513;
    color: #8B4513;
}

.btn-outline-primary:hover, .btn-check:checked + .btn-outline-primary {
    background-color: #8B4513;
    border-color: #8B4513;
    color: white;
}

.btn-primary {
    background-color: #8B4513;
    border-color: #8B4513;
}

.btn-primary:hover {
    background-color: #6d3410;
    border-color: #6d3410;
}

.badge.bg-success {
    background-color: #198754 !important;
}
</style>

<script>
function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        // Add AJAX call to cancel order
        fetch(`/user/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to cancel order. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}
</script>
@endsection
