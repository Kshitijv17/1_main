@extends('admin.layout')

@section('title', 'View Content')
@section('page-title', 'View Content')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">{{ $cms->title }}</h2>
            <div class="d-flex align-items-center gap-2">
                {!! $cms->type_badge !!}
                {!! $cms->status_badge !!}
                @if($cms->is_featured)
                    <span class="badge bg-warning">Featured</span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cms.edit', $cms) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.cms.duplicate', $cms) }}" class="btn btn-outline-secondary">
                <i class="fas fa-copy me-2"></i>Duplicate
            </a>
            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to CMS
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Content Preview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Content Preview
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Featured Image -->
                    @if($cms->featured_image)
                        <div class="mb-4">
                            <img src="{{ $cms->getFeaturedImageUrl() }}" alt="{{ $cms->title }}" 
                                 class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Title and Excerpt -->
                    <div class="mb-4">
                        <h1 class="h2 mb-3">{{ $cms->title }}</h1>
                        @if($cms->excerpt)
                            <p class="lead text-muted">{{ $cms->excerpt }}</p>
                        @endif
                    </div>

                    <!-- Content -->
                    @if($cms->content)
                        <div class="content-body">
                            {!! $cms->content !!}
                        </div>
                    @endif

                    <!-- Gallery -->
                    @if($cms->gallery && count($cms->gallery) > 0)
                        <div class="mt-4">
                            <h5>Gallery</h5>
                            <div class="row">
                                @foreach($cms->gallery as $image)
                                    <div class="col-md-4 mb-3">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             class="img-fluid rounded" 
                                             style="height: 200px; width: 100%; object-fit: cover;"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#imageModal" 
                                             data-image="{{ asset('storage/' . $image) }}"
                                             style="cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Information -->
            @if($cms->seo_title || $cms->seo_description || $cms->seo_keywords)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-search me-2"></i>SEO Information
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($cms->seo_title)
                            <div class="mb-3">
                                <label class="form-label fw-bold">SEO Title:</label>
                                <p class="mb-0">{{ $cms->seo_title }}</p>
                            </div>
                        @endif

                        @if($cms->seo_description)
                            <div class="mb-3">
                                <label class="form-label fw-bold">SEO Description:</label>
                                <p class="mb-0">{{ $cms->seo_description }}</p>
                            </div>
                        @endif

                        @if($cms->seo_keywords)
                            <div class="mb-3">
                                <label class="form-label fw-bold">SEO Keywords:</label>
                                <p class="mb-0">
                                    @foreach(explode(',', $cms->seo_keywords) as $keyword)
                                        <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Content Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Content Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Type:</label>
                        <p class="mb-0">{!! $cms->type_badge !!}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p class="mb-0">{!! $cms->status_badge !!}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug:</label>
                        <p class="mb-0">
                            <code>{{ $cms->slug }}</code>
                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $cms->slug }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </p>
                    </div>

                    @if($cms->published_at)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Published:</label>
                            <p class="mb-0">{{ $cms->published_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sort Order:</label>
                        <p class="mb-0">{{ $cms->sort_order }}</p>
                    </div>

                    @if($cms->is_featured)
                        <div class="mb-3">
                            <span class="badge bg-warning">
                                <i class="fas fa-star me-1"></i>Featured Content
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Author Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Author Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Created by:</label>
                        <p class="mb-0">{{ $cms->creator->name }}</p>
                        <small class="text-muted">{{ $cms->created_at->format('M d, Y \a\t H:i') }}</small>
                    </div>

                    @if($cms->updater && $cms->updater->id !== $cms->creator->id)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last updated by:</label>
                            <p class="mb-0">{{ $cms->updater->name }}</p>
                            <small class="text-muted">{{ $cms->updated_at->format('M d, Y \a\t H:i') }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.edit', $cms) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Content
                        </a>
                        
                        <a href="{{ route('admin.cms.duplicate', $cms) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-copy me-2"></i>Duplicate Content
                        </a>

                        @if($cms->status === 'draft')
                            <form method="POST" action="{{ route('admin.cms.update', $cms) }}" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="published">
                                <input type="hidden" name="title" value="{{ $cms->title }}">
                                <input type="hidden" name="type" value="{{ $cms->type }}">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Publish Now
                                </button>
                            </form>
                        @elseif($cms->status === 'published')
                            <form method="POST" action="{{ route('admin.cms.update', $cms) }}" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="draft">
                                <input type="hidden" name="title" value="{{ $cms->title }}">
                                <input type="hidden" name="type" value="{{ $cms->type }}">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-file-alt me-2"></i>Move to Draft
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-outline-danger" onclick="deleteContent()">
                            <i class="fas fa-trash me-2"></i>Delete Content
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid">
            </div>
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
                <p>Are you sure you want to delete "<strong>{{ $cms->title }}</strong>"?</p>
                <p class="text-danger">This action cannot be undone and will permanently delete all associated media files.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.cms.destroy', $cms) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.content-body {
    line-height: 1.8;
}

.content-body h1, .content-body h2, .content-body h3, 
.content-body h4, .content-body h5, .content-body h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.content-body blockquote {
    border-left: 4px solid var(--primary-green);
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background: var(--background-soft);
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}

.content-body ul, .content-body ol {
    padding-left: 2rem;
    margin-bottom: 1.5rem;
}

.content-body li {
    margin-bottom: 0.5rem;
}

.content-body table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.content-body th, .content-body td {
    border: 1px solid var(--border-light);
    padding: 0.75rem;
    text-align: left;
}

.content-body th {
    background: var(--background-soft);
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// Image modal functionality
document.getElementById('imageModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const imageSrc = button.getAttribute('data-image');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc;
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    Slug copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function () {
            document.body.removeChild(toast);
        });
    });
}

// Delete content function
function deleteContent() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
@endsection
