@extends('admin.layout')

@section('title', 'Content Management System')
@section('page-title', 'CMS Content')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Content Management</h2>
            <p class="text-muted mb-0">Manage your website content, pages, and posts</p>
        </div>
        <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Content
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cms.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search content..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card mb-4" id="bulk-actions" style="display: none;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.cms.bulk-action') }}" id="bulk-form">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span class="text-muted">
                            <span id="selected-count">0</span> items selected
                        </span>
                    </div>
                    <div class="col-md-6 text-end">
                        <select name="action" class="form-select d-inline-block w-auto me-2" required>
                            <option value="">Choose Action</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Move to Draft</option>
                            <option value="archive">Archive</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="btn btn-warning btn-sm">Apply</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearSelection()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Content Table -->
    <div class="card">
        <div class="card-body">
            @if($contents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th width="80">Image</th>
                                <th>Title</th>
                                <th width="100">Type</th>
                                <th width="100">Status</th>
                                <th width="120">Created</th>
                                <th width="120">Updated</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $content)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="{{ $content->id }}" 
                                               class="form-check-input item-checkbox">
                                    </td>
                                    <td>
                                        @if($content->featured_image)
                                            <img src="{{ $content->getFeaturedImageUrl() }}" 
                                                 alt="{{ $content->title }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 4px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $content->title }}</h6>
                                            @if($content->excerpt)
                                                <small class="text-muted">{{ Str::limit($content->excerpt, 60) }}</small>
                                            @endif
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="fas fa-link me-1"></i>{{ $content->slug }}
                                                </small>
                                                @if($content->is_featured)
                                                    <span class="badge bg-warning ms-2">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{!! $content->type_badge !!}</td>
                                    <td>{!! $content->status_badge !!}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $content->created_at->format('M d, Y') }}<br>
                                            by {{ $content->creator->name }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $content->updated_at->format('M d, Y') }}
                                            @if($content->updater)
                                                <br>by {{ $content->updater->name }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.cms.show', $content) }}" 
                                               class="btn btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.edit', $content) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.duplicate', $content) }}" 
                                               class="btn btn-outline-secondary" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="deleteContent({{ $content->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $contents->firstItem() }} to {{ $contents->lastItem() }} of {{ $contents->total() }} results
                    </div>
                    {{ $contents->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5>No Content Found</h5>
                    <p class="text-muted">Start by creating your first content piece.</p>
                    <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Content
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this content? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Individual checkbox functionality
document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    if (checkedBoxes.length > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = checkedBoxes.length;
        
        // Add selected IDs to bulk form
        const bulkForm = document.getElementById('bulk-form');
        // Remove existing hidden inputs
        bulkForm.querySelectorAll('input[name="selected_items[]"]').forEach(input => input.remove());
        
        // Add new hidden inputs
        checkedBoxes.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selected_items[]';
            hiddenInput.value = checkbox.value;
            bulkForm.appendChild(hiddenInput);
        });
    } else {
        bulkActions.style.display = 'none';
    }
}

function clearSelection() {
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('select-all').checked = false;
    updateBulkActions();
}

function deleteContent(id) {
    const form = document.getElementById('delete-form');
    form.action = `/admin/cms/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Bulk form submission confirmation
document.getElementById('bulk-form').addEventListener('submit', function(e) {
    const action = this.querySelector('select[name="action"]').value;
    if (action === 'delete') {
        if (!confirm('Are you sure you want to delete the selected content? This action cannot be undone.')) {
            e.preventDefault();
        }
    }
});
</script>
@endpush
@endsection
