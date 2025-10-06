@extends('admin.layout')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-shopping-cart me-2" style="color: #f59e0b;"></i>
                Order {{ $order->order_number }}
            </h1>
            <p class="text-white-50 mb-0">Order Details and Management</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Back to Orders
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                <i class="fas fa-edit me-2"></i>Update Status
            </button>
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
        <!-- Order Information -->
        <div class="col-md-4">
            <!-- Order Summary Card -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-white mb-2">
                            <i class="fas fa-hashtag me-2 text-primary"></i>Order Details
                        </h6>
                        <div class="ps-4">
                            <p class="text-muted mb-1">
                                <strong>Order Date:</strong> 
                                <span class="text-dark">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Total Amount:</strong> 
                                <span class="text-success fw-bold">${{ number_format($order->total_amount, 2) }}</span>
                            </p>
                            <p class="text-muted mb-1">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : ($order->status === 'processing' ? 'info' : 'warning')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p class="text-muted mb-0">
                                <strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-dark mb-2">
                            <i class="fas fa-credit-card me-2 text-primary"></i>Payment Information
                        </h6>
                        <div class="ps-4">
                            <p class="text-muted mb-1">
                                <strong>Method:</strong> {{ $order->payment_method ?: 'Not specified' }}
                            </p>
                            <p class="text-muted mb-0">
                                <strong>Currency:</strong> {{ strtoupper($order->currency) }}
                            </p>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <h6 class="text-dark mb-2">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Notes
                            </h6>
                            <div class="ps-4">
                                <p class="text-muted mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- user Information Card -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-user me-2"></i>
                        user Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h6 class="text-dark mb-1">{{ $order->user->name }}</h6>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end border-secondary">
                                <h6 class="text-primary mb-1">Role</h6>
                                <span class="badge bg-{{ $order->user->role->getBadgeColor() }}">{{ $order->user->role->getDisplayName() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-success mb-1">Member Since</h6>
                            <small class="text-muted">{{ $order->user->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Information Card -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-store me-2"></i>
                        Shop Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($order->shop->logo)
                            <img src="{{ asset('storage/' . $order->shop->logo) }}" 
                                 alt="{{ $order->shop->name }}" 
                                 class="rounded me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-store text-white"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="text-dark mb-1">{{ $order->shop->name }}</h6>
                            <small class="text-muted">{{ $order->shop->email }}</small>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end border-secondary">
                                <h6 class="text-info mb-1">Status</h6>
                                <span class="badge bg-{{ $order->shop->is_active ? 'success' : 'danger' }}">
                                    {{ $order->shop->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-warning mb-1">Location</h6>
                            <small class="text-muted">{{ $order->shop->city }}, {{ $order->shop->country }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-list me-2"></i>
                        Order Items ({{ $order->items->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $options = json_decode($item->product_options, true) ?? [];
                                                    $image = $options['image'] ?? null;
                                                @endphp
                                                @if($image)
                                                    <img src="{{ asset('storage/' . $image) }}" 
                                                         alt="{{ $item->product_name }}" 
                                                         class="rounded me-3" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong class="text-dark">{{ $item->product_name }}</strong>
                                                    @if($item->product_sku)
                                                        <br>
                                                        <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @endif
                                                    @if($item->product && $item->product->category)
                                                        <br>
                                                        <small class="text-info">{{ $item->product->category->title }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary fs-6">{{ $item->quantity }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($item->unit_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($item->total_price, 2) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Totals -->
            <div class="card bg-white border border-gray-200 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom border-gray-200">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Order Totals
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted">Subtotal:</td>
                                    <td class="text-end text-dark">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tax Amount:</td>
                                    <td class="text-end text-dark">${{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Shipping:</td>
                                    <td class="text-end text-dark">${{ number_format($order->shipping_amount, 2) }}</td>
                                </tr>
                                @if($order->discount_amount > 0)
                                    <tr>
                                        <td class="text-muted">Discount:</td>
                                        <td class="text-end text-danger">-${{ number_format($order->discount_amount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="border-top border-gray-200">
                                    <td class="text-dark"><strong>Total Amount:</strong></td>
                                    <td class="text-end text-success"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Billing Address -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-header bg-white border-bottom border-gray-200">
                            <h5 class="card-title text-dark mb-0">
                                <i class="fas fa-shipping-fast me-2"></i>
                                Shipping Address
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $shippingAddress = json_decode($order->shipping_address, true) ?? [];
                            @endphp
                            @if(!empty($shippingAddress))
                                <address class="text-muted mb-0">
                                    <strong>{{ $shippingAddress['name'] ?? 'N/A' }}</strong><br>
                                    {{ $shippingAddress['address'] ?? 'N/A' }}<br>
                                    {{ $shippingAddress['city'] ?? 'N/A' }}, {{ $shippingAddress['state'] ?? 'N/A' }} {{ $shippingAddress['zip'] ?? 'N/A' }}<br>
                                    {{ $shippingAddress['country'] ?? 'N/A' }}<br>
                                    @if(!empty($shippingAddress['phone']))
                                        <strong>Phone:</strong> {{ $shippingAddress['phone'] }}<br>
                                    @endif
                                    <strong>Email:</strong> {{ $shippingAddress['email'] ?? 'N/A' }}
                                </address>
                            @else
                                <p class="text-muted">No shipping address provided</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-white border border-gray-200 shadow-sm">
                        <div class="card-header bg-white border-bottom border-gray-200">
                            <h5 class="card-title text-dark mb-0">
                                <i class="fas fa-file-invoice me-2"></i>
                                Billing Address
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $billingAddress = json_decode($order->billing_address, true) ?? [];
                            @endphp
                            @if(!empty($billingAddress))
                                <address class="text-muted mb-0">
                                    <strong>{{ $billingAddress['name'] ?? 'N/A' }}</strong><br>
                                    {{ $billingAddress['address'] ?? 'N/A' }}<br>
                                    {{ $billingAddress['city'] ?? 'N/A' }}, {{ $billingAddress['state'] ?? 'N/A' }} {{ $billingAddress['zip'] ?? 'N/A' }}<br>
                                    {{ $billingAddress['country'] ?? 'N/A' }}<br>
                                    @if(!empty($billingAddress['phone']))
                                        <strong>Phone:</strong> {{ $billingAddress['phone'] }}<br>
                                    @endif
                                    <strong>Email:</strong> {{ $billingAddress['email'] ?? 'N/A' }}
                                </address>
                            @else
                                <p class="text-muted">No billing address provided</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">Update Order Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white">Order Status</label>
                        <select name="status" class="form-select bg-secondary border-0 text-white" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Notes (Optional)</label>
                        <textarea name="notes" class="form-control bg-secondary border-0 text-white" rows="3" 
                                  placeholder="Add any notes about this status update..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Payment Status Modal -->
<div class="modal fade" id="updatePaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">Update Payment Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-payment-status', $order) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white">Payment Status</label>
                        <select name="payment_status" class="form-select bg-secondary border-0 text-white" required>
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Payment Method</label>
                        <input type="text" name="payment_method" class="form-control bg-secondary border-0 text-white" 
                               value="{{ $order->payment_method }}" placeholder="e.g., Credit Card, PayPal, etc.">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add payment status update button
    const updateStatusBtn = document.querySelector('[data-bs-target="#updateStatusModal"]');
    if (updateStatusBtn) {
        const paymentBtn = updateStatusBtn.cloneNode(true);
        paymentBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Update Payment';
        paymentBtn.setAttribute('data-bs-target', '#updatePaymentModal');
        paymentBtn.classList.remove('btn-primary');
        paymentBtn.classList.add('btn-success');
        updateStatusBtn.parentNode.insertBefore(paymentBtn, updateStatusBtn.nextSibling);
    }
});
</script>
@endsection
