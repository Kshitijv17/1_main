@extends('admin.layout')

@section('title', 'Order Categories')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-white">
                <i class="fas fa-sort me-2" style="color: #f59e0b;"></i>
                Order Categories
            </h1>
            <p class="text-white-50 mb-0">Drag and drop to reorder categories</p>
        </div>
        <div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Back to Categories
            </a>
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

    <!-- Category Ordering Card -->
    <div class="card bg-dark border-0 shadow-lg">
        <div class="card-header bg-gradient-primary border-0">
            <h5 class="card-title text-white mb-0">
                <i class="fas fa-list-ol me-2"></i>
                Category Order Management
            </h5>
        </div>
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="row">
                    <div class="col-md-8">
                        <!-- Instructions -->
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Instructions:</strong> Drag and drop the categories below to reorder them. 
                            The order will be saved automatically when you drop an item.
                        </div>

                        <!-- Sortable Category List -->
                        <div id="sortable-categories" class="sortable-list">
                            @foreach($categories as $index => $category)
                                <div class="sortable-item" data-id="{{ $category->id }}">
                                    <div class="d-flex align-items-center p-3 bg-dark rounded mb-2 border border-secondary">
                                        <!-- Drag Handle -->
                                        <div class="drag-handle me-3">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </div>

                                        <!-- Order Number -->
                                        <div class="order-number me-3">
                                            <span class="badge bg-primary fs-6">{{ $category->sort_order ?: $index + 1 }}</span>
                                        </div>

                                        <!-- Category Info -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center">
                                                @if($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                                         alt="{{ $category->title }}" 
                                                         class="rounded me-3" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif

                                                <div>
                                                    <h6 class="text-white mb-1">{{ $category->title }}</h6>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge {{ $category->active === 'active' ? 'bg-success' : 'bg-danger' }} me-2">
                                                            {{ ucfirst($category->active) }}
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ $category->products_count ?? $category->products->count() }} products
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="actions">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-warning me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Save Button -->
                        <div class="mt-4">
                            <button type="button" id="save-order" class="btn btn-success btn-lg" disabled>
                                <i class="fas fa-save me-2"></i>Save Order
                            </button>
                            <button type="button" id="reset-order" class="btn btn-outline-secondary btn-lg ms-2">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Tips Card -->
                        <div class="card bg-gradient-info border-0">
                            <div class="card-body">
                                <h6 class="card-title text-white">
                                    <i class="fas fa-lightbulb me-2"></i>Tips
                                </h6>
                                <ul class="text-white-75 mb-0 small">
                                    <li>Categories with lower order numbers appear first</li>
                                    <li>Drag the grip icon to reorder categories</li>
                                    <li>Changes are saved automatically when you drop an item</li>
                                    <li>The order affects how categories appear on the website</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Statistics Card -->
                        <div class="card bg-gradient-success border-0 mt-3">
                            <div class="card-body">
                                <h6 class="card-title text-white">
                                    <i class="fas fa-chart-bar me-2"></i>Statistics
                                </h6>
                                <div class="text-white-75">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Categories:</span>
                                        <strong>{{ $categories->count() }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Active Categories:</span>
                                        <strong>{{ $categories->where('active', 'active')->count() }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Inactive Categories:</span>
                                        <strong>{{ $categories->where('active', 'inactive')->count() }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-white">No Categories Found</h4>
                    <p class="text-muted">Create some categories first to manage their order.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.sortable-list {
    min-height: 200px;
}

.sortable-item {
    cursor: move;
    transition: all 0.3s ease;
}

.sortable-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.sortable-item.ui-sortable-helper {
    transform: rotate(5deg);
    box-shadow: 0 8px 16px rgba(0,0,0,0.4);
}

.sortable-item.ui-sortable-placeholder {
    background: rgba(245, 158, 11, 0.2);
    border: 2px dashed #f59e0b;
    height: 80px;
}

.drag-handle {
    cursor: grab;
}

.drag-handle:active {
    cursor: grabbing;
}

.order-number {
    min-width: 40px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75);
}
</style>

<!-- Include jQuery UI for sortable functionality -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    let originalOrder = [];
    let hasChanges = false;

    // Initialize sortable
    $("#sortable-categories").sortable({
        handle: '.drag-handle',
        placeholder: 'ui-sortable-placeholder',
        helper: 'clone',
        start: function(event, ui) {
            // Store original order
            if (originalOrder.length === 0) {
                originalOrder = $(this).sortable('toArray', {attribute: 'data-id'});
            }
        },
        update: function(event, ui) {
            hasChanges = true;
            $('#save-order').prop('disabled', false);
            
            // Update order numbers
            updateOrderNumbers();
            
            // Auto-save after a short delay
            setTimeout(saveOrder, 1000);
        }
    });

    // Update order numbers in the UI
    function updateOrderNumbers() {
        $('#sortable-categories .sortable-item').each(function(index) {
            $(this).find('.order-number .badge').text(index + 1);
        });
    }

    // Save order function
    function saveOrder() {
        if (!hasChanges) return;

        const categoryIds = $('#sortable-categories').sortable('toArray', {attribute: 'data-id'});
        
        $.ajax({
            url: '{{ route("admin.categories.update-order") }}',
            method: 'POST',
            data: {
                categories: categoryIds,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#save-order').html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Category order updated successfully!', 'success');
                    hasChanges = false;
                    originalOrder = categoryIds;
                    $('#save-order').html('<i class="fas fa-save me-2"></i>Save Order').prop('disabled', true);
                } else {
                    showNotification('Failed to update category order', 'error');
                    $('#save-order').html('<i class="fas fa-save me-2"></i>Save Order').prop('disabled', false);
                }
            },
            error: function() {
                showNotification('An error occurred while saving', 'error');
                $('#save-order').html('<i class="fas fa-save me-2"></i>Save Order').prop('disabled', false);
            }
        });
    }

    // Manual save button
    $('#save-order').click(function() {
        saveOrder();
    });

    // Reset order button
    $('#reset-order').click(function() {
        if (originalOrder.length > 0) {
            // Restore original order
            const container = $('#sortable-categories');
            originalOrder.forEach(function(id) {
                const item = container.find(`[data-id="${id}"]`);
                container.append(item);
            });
            
            updateOrderNumbers();
            hasChanges = false;
            $('#save-order').prop('disabled', true);
            showNotification('Order reset to original state', 'info');
        }
    });

    // Show notification function
    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.alert('close');
        }, 5000);
    }
});
</script>
@endsection
