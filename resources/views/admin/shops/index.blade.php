@extends('admin.layout')

@section('title', 'Shop Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-store me-2" style="color: #f59e0b;"></i>
                Shop Management
            </h1>
            <p class="text-white-50 mb-0">Manage all shops and vendors on the platform</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.shops.export', request()->query()) }}" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
            <a href="{{ route('admin.shops.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create Shop
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
                            <h6 class="card-title text-muted">Total Shops</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['total_shops']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-store fa-2x text-primary opacity-75"></i>
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
                            <h6 class="card-title text-muted">Active Shops</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['active_shops']) }}</h3>
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
                            <h6 class="card-title text-muted">Inactive Shops</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['inactive_shops']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times-circle fa-2x text-warning opacity-75"></i>
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
                            <h6 class="card-title text-muted">Total Products</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['total_products']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x text-info opacity-75"></i>
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
                            <h6 class="card-title text-muted">Total Orders</h6>
                            <h3 class="mb-0 text-dark">{{ number_format($stats['total_orders']) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-cart fa-2x text-secondary opacity-75"></i>
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
    </div>

    <!-- Filters -->
    <div class="card bg-white border border-gray-200 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.shops.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-dark">Search</label>
                        <input type="text" name="search" class="form-control border-gray-300" 
                               placeholder="Shop name, email, phone, admin name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">Status</label>
                        <select name="status" class="form-select border-gray-300">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">Sort By</label>
                        <select name="sort" class="form-select border-gray-300">
                            <option value="">Latest First</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="products" {{ request('sort') === 'products' ? 'selected' : '' }}>Products Count</option>
                            <option value="orders" {{ request('sort') === 'orders' ? 'selected' : '' }}>Orders Count</option>
                            <option value="revenue" {{ request('sort') === 'revenue' ? 'selected' : '' }}>Revenue</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-dark">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Shops Table -->
    <div class="card bg-white border border-gray-200 shadow-sm">
        <div class="card-header bg-white border-bottom border-gray-200">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0">
                    <i class="fas fa-list me-2"></i>
                    Shops ({{ $shops->total() }})
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleBulkActions()">
                        <i class="fas fa-tasks me-1"></i>Bulk Actions
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($shops->count() > 0)
                <!-- Bulk Actions (Hidden by default) -->
                <div id="bulk-actions" class="p-3 bg-light border-bottom border-gray-200" style="display: none;">
                    <form id="bulk-form" method="POST" action="{{ route('admin.shops.bulk-action') }}">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label text-dark">Action</label>
                                <select name="action" class="form-select border-gray-300" required>
                                    <option value="">Select Action</option>
                                    <option value="activate">Activate Shops</option>
                                    <option value="deactivate">Deactivate Shops</option>
                                    <option value="delete">Delete Shops</option>
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
                                <th>Shop</th>
                                <th>Admin</th>
                                <th>Contact</th>
                                <th>Location</th>
                                <th>Products</th>
                                <th>Orders</th>
                                <th>Revenue</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="shop_ids[]" value="{{ $shop->id }}" 
                                               class="form-check-input shop-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($shop->logo)
                                                <img src="{{ asset('storage/' . $shop->logo) }}" 
                                                     alt="{{ $shop->name }}" 
                                                     class="rounded me-3" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-store text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong class="text-dark">{{ $shop->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $shop->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($shop->admin)
                                            <div>
                                                <strong class="text-info">{{ $shop->admin->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $shop->admin->email }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">No Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-dark">{{ $shop->email }}</small>
                                            <br>
                                            <small class="text-muted">{{ $shop->phone }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $shop->city }}, {{ $shop->state }}
                                            <br>
                                            {{ $shop->country }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($shop->products_count) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ number_format($shop->orders_count) }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($shop->orders_sum_total_amount ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $shop->is_active ? 'success' : 'danger' }}">
                                            {{ $shop->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.shops.show', $shop) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.shops.edit', $shop) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.shops.toggle-status', $shop) }}" 
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-{{ $shop->is_active ? 'danger' : 'success' }}" 
                                                        title="{{ $shop->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $shop->is_active ? 'times' : 'check' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-3 border-top border-gray-200">
                    {{ $shops->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-store fa-4x text-muted mb-3"></i>
                    <h4 class="text-dark">No Shops Found</h4>
                    <p class="text-muted">No shops match your current filters.</p>
                    <a href="{{ route('admin.shops.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Shop
                    </a>
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
.bg-gradient-secondary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
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
        const checkboxes = document.querySelectorAll('.shop-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk form submission
    document.getElementById('bulk-form').addEventListener('submit', function(e) {
        const selectedShops = document.querySelectorAll('.shop-checkbox:checked');
        
        if (selectedShops.length === 0) {
            e.preventDefault();
            alert('Please select at least one shop.');
            return;
        }

        const action = document.querySelector('select[name="action"]').value;
        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete the selected shops? This action cannot be undone and will also delete all associated products and admin users.')) {
                e.preventDefault();
                return;
            }
        }

        // Add selected shop IDs to form
        selectedShops.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'shop_ids[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
});
</script>
@endsection
