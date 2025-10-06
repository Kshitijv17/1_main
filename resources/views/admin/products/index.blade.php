@extends('admin.layout')

@section('title', 'Products Management')
@section('page-title', 'Products')

@section('content')
<!-- Imperial Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border: 1px solid var(--gold-color); position: relative; overflow: hidden;">
            <div class="card-body py-4 position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center position-relative gap-3">
                    <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                        <div class="me-md-4 mb-3 mb-md-0" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-box-open" style="color: var(--darker-color); font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h2 class="mb-1" style="color: var(--gold-color); font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.4rem;">Products Management</h2>
                            <p class="mb-0 text-light" style="opacity: 0.9; font-size: 0.9rem;">Oversee all products across the marketplace</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-column flex-sm-row w-100 w-lg-auto">
                        <a href="{{ route('admin.products.bulk-upload-form') }}" class="btn btn-outline-warning" style="border-color: var(--gold-color); color: var(--gold-color); font-weight: 600; padding: 0.5rem 1rem; font-size: 0.9rem;">
                            <i class="fas fa-upload me-2"></i><span class="d-none d-sm-inline">Bulk Upload</span><span class="d-sm-none">Upload</span>
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600; padding: 0.5rem 1rem; font-size: 0.9rem;">
                            <i class="fas fa-plus-circle me-2"></i><span class="d-none d-sm-inline">Add Product</span><span class="d-sm-none">Add</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)); border: 1px solid rgba(16, 185, 129, 0.3); color: #059669;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('bulk_errors'))
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); border: 1px solid rgba(245, 158, 11, 0.3); color: #d97706;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Bulk Upload Completed with Issues:</strong> Some products could not be uploaded due to validation errors.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(59, 130, 246, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color); font-size: 0.8rem;">Total</h6>
                        <h5 class="mb-0 text-white">{{ $stats['total_products'] }}</h5>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-lg" style="color: var(--gold-color); opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(16, 185, 129, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color); font-size: 0.8rem;">Active</h6>
                        <h5 class="mb-0 text-white">{{ $stats['active_products'] }}</h5>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-lg" style="color: #10b981; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(239, 68, 68, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color);">Inactive</h6>
                        <h4 class="mb-0 text-white">{{ $stats['inactive_products'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x" style="color: #ef4444; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color);">Featured</h6>
                        <h4 class="mb-0 text-white">{{ $stats['featured_products'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x" style="color: var(--gold-color); opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(168, 85, 247, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color);">Low Stock</h6>
                        <h4 class="mb-0 text-white">{{ $stats['low_stock'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: #a855f7; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(99, 102, 241, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-body text-center py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1" style="color: var(--gold-color);">Shops</h6>
                        <h4 class="mb-0 text-white">{{ $stats['total_shops'] }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-store fa-2x" style="color: #6366f1; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Premium Products Table -->
<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(255, 255, 255, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border-bottom: 1px solid var(--glass-border);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--gold-color); font-weight: 600;">
                        <i class="fas fa-crown me-2"></i>Products Registry
                    </h5>
                    <div class="badge px-3 py-2" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); color: white; font-weight: 600;">
                        {{ $products->count() }} Products
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="--bs-table-bg: transparent;">
                            <thead style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                                <tr>
                                    <th style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Image</th>
                                    <th style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Product</th>
                                    <th class="d-none d-md-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Shop</th>
                                    <th class="d-none d-lg-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Category</th>
                                    <th class="d-none d-sm-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Price</th>
                                    <th class="d-none d-lg-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Sale Price</th>
                                    <th class="d-none d-md-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Stock</th>
                                    <th class="d-none d-lg-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Status</th>
                                    <th class="d-none d-xl-table-cell" style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Discount</th>
                                    <th style="border: none; padding: 0.75rem 0.5rem; font-size: 0.8rem;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr style="border-bottom: 1px solid var(--glass-border);">
                                    <td style="padding: 0.75rem 0.5rem;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--glass-border);">
                                        @elseif($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->title }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--glass-border);">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: var(--glass-bg); border: 2px solid var(--glass-border);">
                                                <i class="fas fa-image" style="color: var(--gold-color); opacity: 0.5; font-size: 0.9rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 0.5rem;">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ Str::limit($product->title, 30) }}</div>
                                        <small style="color: var(--gold-color); opacity: 0.7; font-size: 0.75rem;" class="d-none d-sm-block">{{ Str::limit($product->description, 30) }}</small>
                                        <div class="d-md-none mt-1">
                                            @if($product->shop)
                                                <small style="color: var(--gold-color); opacity: 0.8; font-size: 0.7rem;">{{ Str::limit($product->shop->name, 15) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="padding: 0.75rem 0.5rem;">
                                        @if($product->shop)
                                            <div class="fw-bold" style="color: var(--gold-color); font-size: 0.85rem;">{{ Str::limit($product->shop->name, 15) }}</div>
                                            <small class="text-light" style="opacity: 0.7; font-size: 0.7rem;">{{ Str::limit($product->shop->admin->name ?? 'N/A', 15) }}</small>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem;">No Shop</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell" style="padding: 0.75rem 0.5rem;">
                                        @if($product->category)
                                            <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, var(--info-color), #0e7490); color: white; font-weight: 600; font-size: 0.7rem;">
                                                {{ Str::limit($product->category->title, 10) }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-sm-table-cell" style="padding: 0.75rem 0.5rem;">
                                        <span class="fw-bold" style="color: var(--gold-color); font-size: 0.85rem;">₹{{ number_format($product->price, 0) }}</span>
                                        @if($product->selling_price && $product->selling_price < $product->price)
                                            <br><small class="text-success" style="font-size: 0.7rem;">₹{{ number_format($product->selling_price, 0) }}</small>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell" style="padding: 0.75rem 0.5rem;">
                                        @if($product->selling_price)
                                            <span class="fw-bold text-success" style="font-size: 0.85rem;">₹{{ number_format($product->selling_price, 0) }}</span>
                                            <br><small style="color: var(--gold-color); opacity: 0.7; font-size: 0.7rem;">{{ number_format((($product->price - $product->selling_price) / $product->price) * 100, 0) }}% off</small>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem;">—</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell" style="padding: 0.75rem 0.5rem;">
                                        <span class="badge px-2 py-1 rounded-pill" style="background: {{ $product->quantity > 0 ? 'linear-gradient(135deg, var(--success-color), #059669)' : 'linear-gradient(135deg, var(--danger-color), #dc2626)' }}; color: white; font-weight: 600; font-size: 0.7rem;">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell" style="padding: 0.75rem 0.5rem;">
                                        <span class="badge px-2 py-1 rounded-pill" style="background: {{ $product->is_active ? 'linear-gradient(135deg, var(--success-color), #059669)' : 'linear-gradient(135deg, var(--warning-color), #d97706)' }}; color: {{ $product->is_active ? 'white' : 'var(--darker-color)' }}; font-weight: 600; font-size: 0.7rem;">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="d-none d-xl-table-cell" style="padding: 0.75rem 0.5rem;">
                                        @if($product->discount_tag)
                                            <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, {{ $product->discount_color }}, #7c3aed); color: white; font-weight: 600; font-size: 0.7rem;">
                                                {{ $product->discount_tag }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem;">—</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 0.5rem;">
                                        <div class="d-flex gap-1 flex-column flex-sm-row">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--info-color), #0e7490); color: white; border: none; padding: 0.25rem 0.5rem; font-size: 0.8rem;" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--warning-color), #d97706); color: var(--darker-color); border: none; padding: 0.25rem 0.5rem; font-size: 0.8rem;" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm" style="background: linear-gradient(135deg, var(--danger-color), #dc2626); color: white; border: none; padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="return confirm('Delete this product?')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <div class="mb-4" style="opacity: 0.5;">
                            <i class="fas fa-box-open fa-4x" style="color: var(--gold-color);"></i>
                        </div>
                        <h4 class="text-white mb-3">No Products Found</h4>
                        <p class="text-light mb-4" style="opacity: 0.7;">Start by adding your first product to the catalog.</p>
                        <a href="{{ route('admin.products.create') }}" class="btn" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600; padding: 0.75rem 2rem;">
                            <i class="fas fa-plus me-2"></i>Add Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
