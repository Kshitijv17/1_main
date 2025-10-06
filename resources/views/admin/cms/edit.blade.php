@extends('admin.layout')

@section('title', 'Edit Content')
@section('page-title', 'Edit Content')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Edit Content</h2>
            <p class="text-muted mb-0">{{ $cms->title }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cms.show', $cms) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>View
            </a>
            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to CMS
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.cms.update', $cms) }}" enctype="multipart/form-data" id="cms-form">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $cms->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $cms->slug) }}">
                            <div class="form-text">Leave empty to auto-generate from title</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" 
                                      placeholder="Brief description of the content">{{ old('excerpt', $cms->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15">{{ old('content', $cms->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-images me-2"></i>Media
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Current Featured Image -->
                        @if($cms->featured_image)
                            <div class="mb-3">
                                <label class="form-label">Current Featured Image</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $cms->getFeaturedImageUrl() }}" alt="{{ $cms->title }}" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove_featured_image" 
                                               name="remove_featured_image" value="1">
                                        <label class="form-check-label text-danger" for="remove_featured_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="featured_image" class="form-label">
                                {{ $cms->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                            </label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            <div class="form-text">Recommended size: 1200x600px</div>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="featured-preview" class="mt-2"></div>
                        </div>

                        <!-- Current Gallery -->
                        @if($cms->gallery && count($cms->gallery) > 0)
                            <div class="mb-3">
                                <label class="form-label">Current Gallery Images</label>
                                <div class="row">
                                    @foreach($cms->gallery as $index => $image)
                                        <div class="col-md-3 mb-2">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="img-thumbnail w-100" 
                                                     style="height: 100px; object-fit: cover;">
                                                <div class="form-check position-absolute top-0 end-0 m-1">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="remove_gallery_images[]" value="{{ $image }}" 
                                                           id="remove_gallery_{{ $index }}">
                                                    <label class="form-check-label visually-hidden" for="remove_gallery_{{ $index }}">
                                                        Remove
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Check images to remove them</small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Add Gallery Images</label>
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple>
                            <div class="form-text">You can select multiple images to add</div>
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="gallery-preview" class="mt-2 row"></div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-search me-2"></i>SEO Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="seo_title" class="form-label">SEO Title</label>
                            <input type="text" class="form-control @error('seo_title') is-invalid @enderror" 
                                   id="seo_title" name="seo_title" value="{{ old('seo_title', $cms->seo_title) }}" maxlength="60">
                            <div class="form-text">Recommended: 50-60 characters</div>
                            @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="seo_description" class="form-label">SEO Description</label>
                            <textarea class="form-control @error('seo_description') is-invalid @enderror" 
                                      id="seo_description" name="seo_description" rows="3" 
                                      maxlength="160">{{ old('seo_description', $cms->seo_description) }}</textarea>
                            <div class="form-text">Recommended: 150-160 characters</div>
                            @error('seo_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="seo_keywords" class="form-label">SEO Keywords</label>
                            <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror" 
                                   id="seo_keywords" name="seo_keywords" value="{{ old('seo_keywords', $cms->seo_keywords) }}" 
                                   placeholder="keyword1, keyword2, keyword3">
                            <div class="form-text">Separate keywords with commas</div>
                            @error('seo_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cog me-2"></i>Publish Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="type" class="form-label">Content Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $cms->type) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $cms->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $cms->status) === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status', $cms->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                   id="published_at" name="published_at" 
                                   value="{{ old('published_at', $cms->published_at ? $cms->published_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="form-text">Leave empty to publish immediately</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $cms->sort_order) }}" min="0">
                            <div class="form-text">Lower numbers appear first</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $cms->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Content
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Content Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Content Info
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Created:</small><br>
                            <small>{{ $cms->created_at->format('M d, Y \a\t H:i') }}</small><br>
                            <small class="text-muted">by {{ $cms->creator->name }}</small>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Last Updated:</small><br>
                            <small>{{ $cms->updated_at->format('M d, Y \a\t H:i') }}</small>
                            @if($cms->updater)
                                <br><small class="text-muted">by {{ $cms->updater->name }}</small>
                            @endif
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Current Status:</small><br>
                            {!! $cms->status_badge !!}
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Content
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                                <i class="fas fa-file-alt me-2"></i>Save as Draft
                            </button>
                            <a href="{{ route('admin.cms.duplicate', $cms) }}" class="btn btn-outline-info">
                                <i class="fas fa-copy me-2"></i>Duplicate
                            </a>
                            <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'outdent', 'indent', '|',
            'imageUpload', 'blockQuote', 'insertTable', '|',
            'undo', 'redo'
        ]
    })
    .catch(error => {
        console.error(error);
    });

// Auto-generate slug from title (only if slug is empty)
document.getElementById('title').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.value.trim()) {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    }
});

// Featured image preview
document.getElementById('featured_image').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('featured-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Gallery preview
document.getElementById('gallery').addEventListener('change', function() {
    const files = this.files;
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-2';
            col.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    }
});

// Save as draft function
function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.getElementById('cms-form').submit();
}

// Character counters
document.getElementById('seo_title').addEventListener('input', function() {
    const length = this.value.length;
    const counter = this.parentNode.querySelector('.form-text');
    counter.textContent = `${length}/60 characters`;
    if (length > 60) {
        counter.classList.add('text-danger');
    } else {
        counter.classList.remove('text-danger');
    }
});

document.getElementById('seo_description').addEventListener('input', function() {
    const length = this.value.length;
    const counter = this.parentNode.querySelector('.form-text');
    counter.textContent = `${length}/160 characters`;
    if (length > 160) {
        counter.classList.add('text-danger');
    } else {
        counter.classList.remove('text-danger');
    }
});
</script>
@endpush
@endsection
