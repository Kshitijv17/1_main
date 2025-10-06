@extends('admin.layout')

@section('title', 'Edit Shop')
@section('subtitle', 'Update shop information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Shop: {{ $shop->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.shops.show', $shop) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Shop
                        </a>
                        <a href="{{ route('admin.shops.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Shops
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.shops.update', $shop) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-info-circle text-primary"></i> Basic Information</h5>
                                
                                <div class="form-group">
                                    <label for="name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $shop->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $shop->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="admin_id" class="form-label">Shop Owner <span class="text-danger">*</span></label>
                                    <select name="admin_id" id="admin_id" 
                                            class="form-control @error('admin_id') is-invalid @enderror" required>
                                        <option value="">Select Shop Owner</option>
                                        @foreach($availableAdmins as $admin)
                                            <option value="{{ $admin->id }}" 
                                                {{ old('admin_id', $shop->admin_id) == $admin->id ? 'selected' : '' }}>
                                                {{ $admin->name }} ({{ $admin->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('admin_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="commission_rate" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="commission_rate" id="commission_rate" 
                                           class="form-control @error('commission_rate') is-invalid @enderror" 
                                           value="{{ old('commission_rate', $shop->commission_rate) }}" 
                                           min="0" max="100" step="0.01" required>
                                    @error('commission_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-phone text-success"></i> Contact Information</h5>
                                
                                <div class="form-group">
                                    <label for="email" class="form-label">Shop Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $shop->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $shop->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" rows="3"
                                              class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $shop->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="website" class="form-label">Website URL</label>
                                    <input type="url" name="website" id="website" 
                                           class="form-control @error('website') is-invalid @enderror" 
                                           value="{{ old('website', $shop->website) }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Current Images -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3"><i class="fas fa-images text-info"></i> Shop Images</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo" class="form-label">Shop Logo</label>
                                    @if($shop->logo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $shop->logo) }}" 
                                                 alt="Current Logo" class="img-thumbnail" style="max-width: 150px;">
                                            <p class="small text-muted">Current Logo</p>
                                        </div>
                                    @endif
                                    <input type="file" name="logo" id="logo" 
                                           class="form-control @error('logo') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="form-text text-muted">
                                        Recommended size: 200x200px. Leave empty to keep current logo.
                                    </small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner" class="form-label">Shop Banner</label>
                                    @if($shop->banner)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $shop->banner) }}" 
                                                 alt="Current Banner" class="img-thumbnail" style="max-width: 300px;">
                                            <p class="small text-muted">Current Banner</p>
                                        </div>
                                    @endif
                                    <input type="file" name="banner" id="banner" 
                                           class="form-control @error('banner') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="form-text text-muted">
                                        Recommended size: 1200x400px. Leave empty to keep current banner.
                                    </small>
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Status -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" id="is_active" 
                                               class="custom-control-input" 
                                               {{ old('is_active', $shop->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            <strong>Active Shop</strong>
                                            <small class="text-muted d-block">Shop will be visible to customers when active</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shop Statistics -->
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3"><i class="fas fa-chart-bar text-warning"></i> Shop Statistics</h5>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-box"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Products</span>
                                        <span class="info-box-number">{{ $shop->products()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Orders</span>
                                        <span class="info-box-number">{{ $shop->orders()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending Orders</span>
                                        <span class="info-box-number">{{ $shop->orders()->where('status', 'pending')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Revenue</span>
                                        <span class="info-box-number">${{ number_format($shop->orders()->where('payment_status', 'paid')->sum('total_amount'), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Shop
                        </button>
                        <a href="{{ route('admin.shops.show', $shop) }}" class="btn btn-info ml-2">
                            <i class="fas fa-eye"></i> View Shop
                        </a>
                        <a href="{{ route('admin.shops.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview functionality
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if doesn't exist
                if ($(previewId).length === 0) {
                    $(input).after('<div class="mt-2"><img id="' + previewId.substring(1) + '" class="img-thumbnail" style="max-width: 200px;"><p class="small text-muted">New Image Preview</p></div>');
                }
                $(previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#logo').change(function() {
        previewImage(this, '#logo-preview');
    });

    $('#banner').change(function() {
        previewImage(this, '#banner-preview');
    });
});
</script>
@endpush
