@extends('admin.layout')

@section('title', 'Category Domains Management')
@section('page-title', 'Category')

@section('content')
<!-- Imperial Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border: 1px solid var(--gold-color); position: relative; overflow: hidden;">
            <div class="card-body py-4 position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="d-flex justify-content-between align-items-center position-relative">
                    <div class="d-flex align-items-center">
                        <div class="me-4" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-layer-group fa-lg" style="color: var(--darker-color);"></i>
                        </div>
                        <div>
                            <h2 class="mb-1" style="color: var(--gold-color); font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.8rem;">Category</h2>
                            <p class="mb-0 text-light" style="opacity: 0.9;">Organize your category </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.categories.order') }}" class="btn btn-outline-warning" style="border-color: var(--gold-color); color: var(--gold-color); font-weight: 600; padding: 0.75rem 1.5rem;">
                            <i class="fas fa-sort me-2"></i>Sort
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600; padding: 0.75rem 2rem;">
                            <i class="fas fa-plus-circle me-2"></i>Add Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Premium Categories Table -->
<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(255, 255, 255, 0.05)); border: 1px solid var(--glass-border);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border-bottom: 1px solid var(--glass-border);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--gold-color); font-weight: 600;">
                        <i class="fas fa-crown me-2"></i>Category Registry
                    </h5>
                    <div class="badge px-3 py-2" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); color: white; font-weight: 600;">
                        {{ $categories->count() }} Category
                    </div>
                </div>
            </div>
            
            @if($categories->isNotEmpty())
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="--bs-table-bg: transparent;">
                        <thead style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                            <tr>
                                <th width="10%" style="border: none; padding: 1rem;">Icon</th>
                                <th width="25%" style="border: none; padding: 1rem;">Name</th>
                                <th width="15%" style="border: none; padding: 1rem;">Authority Status</th>
                                <th width="15%" style="border: none; padding: 1rem;">Visibility</th>
                                <th width="15%" style="border: none; padding: 1rem;">Last Updated</th>
                                <th width="20%" style="border: none; padding: 1rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr style="border-bottom: 1px solid var(--glass-border);">
                                <td style="padding: 1.25rem 1rem;">
                                    <div class="position-relative">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--gold-color); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                                        @else
                                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--gold-color);">
                                                <i class="fas fa-layer-group" style="color: white; font-size: 1.2rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <div class="fw-bold text-light" style="font-size: 1.1rem;">{{ $category->title }}</div>
                                    <small class="text-muted">Domain ID: #{{ $category->id }}</small>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <span class="badge px-3 py-2 rounded-pill" style="background: {{ $category->active === 'active' ? 'linear-gradient(135deg, var(--success-color), #047857)' : 'linear-gradient(135deg, #6b7280, #4b5563)' }}; color: white; font-weight: 600;">
                                        <i class="fas {{ $category->active === 'active' ? 'fa-shield-check' : 'fa-shield-xmark' }} me-1"></i>
                                        {{ $category->active === 'active' ? 'Active Reign' : 'Dormant' }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <span class="badge px-3 py-2 rounded-pill" style="background: {{ $category->show_on_home === 'show' ? 'linear-gradient(135deg, var(--info-color), #0e7490)' : 'linear-gradient(135deg, var(--warning-color), #d97706)' }}; color: {{ $category->show_on_home === 'show' ? 'white' : 'var(--darker-color)' }}; font-weight: 600;">
                                        <i class="fas {{ $category->show_on_home === 'show' ? 'fa-eye' : 'fa-eye-slash' }} me-1"></i>
                                        {{ $category->show_on_home === 'show' ? 'Public View' : 'Hidden' }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <div class="text-light" style="font-weight: 500;">{{ $category->updated_at ? $category->updated_at->format('M d, Y') : 'N/A' }}</div>
                                    <small class="text-muted">{{ $category->updated_at ? $category->updated_at->format('g:i A') : '' }}</small>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--info-color), #0e7490); color: white; border: none; font-weight: 600;" title="Inspect Domain">
                                            <i class="fas fa-search-plus"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); color: var(--darker-color); border: none; font-weight: 600;" title="Modify Domain">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm" style="background: linear-gradient(135deg, var(--danger-color), #b91c1c); color: white; border: none; font-weight: 600;" onclick="return confirm('Are you sure you want to dissolve this domain? This action cannot be undone.')" title="Dissolve Domain">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="card-body text-center py-5">
                <div class="mb-4" style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.1)); border: 2px solid var(--gold-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="fas fa-layer-group fa-3x" style="color: var(--gold-color);"></i>
                </div>
                <h4 class="text-light mb-3" style="font-family: 'Playfair Display', serif; font-weight: 600;">No Category Domains Established</h4>
                <p class="text-muted mb-4" style="font-size: 1.1rem;">Your empire awaits the creation of its first category domain to organize the realm.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600; padding: 1rem 2rem; font-size: 1.1rem;">
                    <i class="fas fa-plus-circle me-2"></i>Establish First Domain
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
