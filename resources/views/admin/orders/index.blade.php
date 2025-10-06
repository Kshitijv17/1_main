@extends('admin.layout')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-shopping-cart me-2" style="color: #f59e0b;"></i>
                Order Management
            </h1>
            <p class="text-white-50 mb-0">Monitor and manage all orders across the platform</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.analytics') }}" class="btn btn-outline-info">
                <i class="fas fa-chart-line me-2"></i>Analytics
            </a>
            <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Orders</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['total_orders']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-cart fa-2x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Pending</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['pending_orders']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Processing</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['processing_orders']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-cog fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Completed</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['completed_orders']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Revenue</h6>
                            <h3 class="mb-0 text-dark">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-white border border-gray-200 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Pending Payments</h6>
                            <h3 class="mb-0 text-dark">${{ number_format($stats['pending_payments'], 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-credit-card fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card bg-white border border-gray-200 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-dark">Search</label>
                        <input type="text" name="search" class="form-control border-gray-300" 
                               placeholder="Order number, user name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">Status</label>
                        <select name="status" class="form-select border-gray-300">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">Payment Status</label>
                        <select name="payment_status" class="form-select border-gray-300">
                            <option value="">All Payment Statuses</option>
                            @foreach($paymentStatuses as $paymentStatus)
                                <option value="{{ $paymentStatus }}" {{ request('payment_status') === $paymentStatus ? 'selected' : '' }}>
                                    {{ ucfirst($paymentStatus) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">Shop</label>
                        <select name="shop_id" class="form-select border-gray-300">
                            <option value="">All Shops</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}" {{ request('shop_id') == $shop->id ? 'selected' : '' }}>
                                    {{ $shop->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-dark">From</label>
                        <input type="date" name="date_from" class="form-control border-gray-300" 
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-dark">To</label>
                        <input type="date" name="date_to" class="form-control border-gray-300" 
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-dark">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card bg-white border border-gray-200 shadow-sm">
        <div class="card-header bg-white border-bottom border-gray-200">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0">
                    <i class="fas fa-list me-2"></i>
                    Orders ({{ $orders->total() }})
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleBulkActions()">
                        <i class="fas fa-tasks me-1"></i>Bulk Actions
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <!-- Bulk Actions (Hidden by default) -->
                <div id="bulk-actions" class="p-3 bg-light border-bottom border-gray-200" style="display: none;">
                    <form id="bulk-form" method="POST" action="{{ route('admin.orders.bulk-update') }}">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label text-dark">Action</label>
                                <select name="action" class="form-select border-gray-300" required>
                                    <option value="">Select Action</option>
                                    <option value="update_status">Update Status</option>
                                    <option value="update_payment_status">Update Payment Status</option>
                                    <option value="delete">Delete Orders</option>
                                </select>
                            </div>
                            <div class="col-md-2" id="status-field" style="display: none;">
                                <label class="form-label text-dark">Status</label>
                                <select name="status" class="form-select border-gray-300">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2" id="payment-status-field" style="display: none;">
                                <label class="form-label text-dark">Payment Status</label>
                                <select name="payment_status" class="form-select border-gray-300">
                                    @foreach($paymentStatuses as $paymentStatus)
                                        <option value="{{ $paymentStatus }}">{{ ucfirst($paymentStatus) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-bolt me-1"></i>Execute
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>Order #</th>
                                <th>user</th>
                                <th>Shop</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" 
                                               class="form-check-input order-checkbox">
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ $order->order_number }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-dark">{{ $order->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-info">{{ $order->shop->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->items->count() }} items</span>
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
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-3 border-top border-gray-200">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4 class="text-dark">No Orders Found</h4>
                    <p class="text-muted">No orders match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk actions toggle
    window.toggleBulkActions = function() {
        const bulkActions = document.getElementById('bulk-actions');
        bulkActions.style.display = bulkActions.style.display === 'none' ? 'block' : 'none';
    };

    // Select all checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.order-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk action form handling
    document.querySelector('select[name="action"]').addEventListener('change', function() {
        const statusField = document.getElementById('status-field');
        const paymentStatusField = document.getElementById('payment-status-field');
        
        statusField.style.display = 'none';
        paymentStatusField.style.display = 'none';
        
        if (this.value === 'update_status') {
            statusField.style.display = 'block';
        } else if (this.value === 'update_payment_status') {
            paymentStatusField.style.display = 'block';
        }
    });

    // Bulk form submission
    document.getElementById('bulk-form').addEventListener('submit', function(e) {
        const selectedOrders = document.querySelectorAll('.order-checkbox:checked');
        
        if (selectedOrders.length === 0) {
            e.preventDefault();
            alert('Please select at least one order.');
            return;
        }

        const action = document.querySelector('select[name="action"]').value;
        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete the selected orders? This action cannot be undone.')) {
                e.preventDefault();
                return;
            }
        }

        // Add selected order IDs to form
        selectedOrders.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_ids[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
});
</script>
@endsection
