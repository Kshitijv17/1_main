@extends('admin.layout')

@section('title', 'Shop Details - ' . $shop->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-store me-2" style="color: #f59e0b;"></i>
                {{ $shop->name }}
            </h1>
            <p class="text-white-50 mb-0">Shop Details and Performance Overview</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Back to Shops
            </a>
            <a href="{{ route('admin.shops.edit', $shop) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Shop
            </a>
            <form method="POST" action="{{ route('admin.shops.toggle-status', $shop) }}" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-{{ $shop->is_active ? 'danger' : 'success' }}">
                    <i class="fas fa-{{ $shop->is_active ? 'times' : 'check' }} me-2"></i>
                    {{ $shop->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Shop Information -->
        <div class="col-md-4">
            <!-- Shop Profile Card -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Shop Information
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Shop Logo -->
                    <div class="text-center mb-4">
                        @if($shop->logo)
                            <img src="{{ asset('storage/' . $shop->logo) }}" 
                                 alt="{{ $shop->name }}" 
                                 class="rounded-circle border border-3 border-primary"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px;">
                                <i class="fas fa-store fa-3x text-muted"></i>
                            </div>
                        @endif
                        <h4 class="text-dark mt-3 mb-1">{{ $shop->name }}</h4>
                        <span class="badge bg-{{ $shop->is_active ? 'success' : 'danger' }} fs-6">
                            {{ $shop->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Shop Details -->
                    <div class="mb-3">
                        <h6 class="text-dark mb-2">
                            <i class="fas fa-envelope me-2 text-primary"></i>Contact Information
                        </h6>
                        <div class="ps-4">
                            <p class="text-muted mb-1">
                                <strong>Email:</strong> {{ $shop->email }}
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Phone:</strong> {{ $shop->phone }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-dark mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Address
                        </h6>
                        <div class="ps-4">
                            <p class="text-muted mb-1">{{ $shop->address }}</p>
                            <p class="text-muted mb-0">
                                {{ $shop->city }}, {{ $shop->state }} {{ $shop->zip_code }}
                                <br>{{ $shop->country }}
                            </p>
                        </div>
                    </div>

                    @if($shop->description)
                        <div class="mb-3">
                            <h6 class="text-dark mb-2">
                                <i class="fas fa-align-left me-2 text-primary"></i>Description
                            </h6>
                            <p class="text-muted ps-4">{{ $shop->description }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-dark mb-2">
                            <i class="fas fa-calendar me-2 text-primary"></i>Registration
                        </h6>
                        <p class="text-muted ps-4 mb-0">
                            Joined {{ $shop->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Admin Information Card -->
            @if($shop->admin)
                <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-gray-200">
                        <h5 class="card-title text-dark mb-0">
                            <i class="fas fa-user-tie me-2"></i>
                            Shop Administrator
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h6 class="text-dark mb-1">{{ $shop->admin->name }}</h6>
                                <small class="text-muted">{{ $shop->admin->email }}</small>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end border-secondary">
                                    <h6 class="text-primary mb-1">Role</h6>
                                    <span class="badge bg-{{ $shop->admin->role->getBadgeColor() }}">{{ $shop->admin->role->getDisplayName() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-success mb-1">Joined</h6>
                                <small class="text-muted">{{ $shop->admin->created_at->format('M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Performance & Analytics -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-box fa-2x mb-2 text-primary"></i>
                            <h3 class="mb-1 text-dark">{{ number_format($stats['total_products']) }}</h3>
                            <small class="text-muted">Total Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                            <h3 class="mb-1 text-dark">{{ number_format($stats['active_products']) }}</h3>
                            <small class="text-muted">Active Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-cart fa-2x mb-2 text-info"></i>
                            <h3 class="mb-1 text-dark">{{ number_format($stats['total_orders']) }}</h3>
                            <small class="text-muted">Total Orders</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-dollar-sign fa-2x mb-2 text-warning"></i>
                            <h3 class="mb-1 text-dark">${{ number_format($stats['total_revenue'], 2) }}</h3>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status Breakdown -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x mb-2 text-warning"></i>
                            <h3 class="mb-1 text-dark">{{ number_format($stats['pending_orders']) }}</h3>
                            <small class="text-muted">Pending Orders</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-truck fa-2x mb-2 text-success"></i>
                            <h3 class="mb-1 text-dark">{{ number_format($stats['completed_orders']) }}</h3>
                            <small class="text-muted">Completed Orders</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-credit-card fa-2x mb-2 text-secondary"></i>
                            <h3 class="mb-1 text-dark">${{ number_format($stats['pending_revenue'], 2) }}</h3>
                            <small class="text-muted">Pending Revenue</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Recent Orders ({{ $recentOrders->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>user</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong class="text-white">{{ $order->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $order->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : ($order->status === 'processing' ? 'info' : 'warning')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-white">No Orders Yet</h5>
                            <p class="text-muted">This shop hasn't received any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top Products -->
            <div class="card bg-dark border-0 shadow-lg">
                <div class="card-header bg-gradient-success border-0">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-star me-2"></i>
                        Top Products ({{ $topProducts->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Orders</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                                             alt="{{ $product->title }}" 
                                                             class="rounded me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong class="text-white">{{ $product->title }}</strong>
                                                        <br>
                                                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-info">{{ $product->category->title ?? 'Uncategorized' }}</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                                @if($product->discount_price && $product->discount_price < $product->price)
                                                    <br>
                                                    <small class="text-muted">
                                                        <del>${{ number_format($product->discount_price, 2) }}</del>
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $product->order_items_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5 class="text-white">No Products Yet</h5>
                            <p class="text-muted">This shop hasn't added any products yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.bg-gradient-secondary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }

.text-white-75 {
    color: rgba(255, 255, 255, 0.75);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection
