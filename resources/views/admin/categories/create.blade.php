@extends('admin.layout')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Category</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <!-- Category Title -->
              <div class="col-md-6 mb-3">
                <label for="title" class="form-label">
                  <i class="fas fa-tag me-1"></i>Category Title <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" placeholder="Enter category title" required>
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category Image -->
              <div class="col-md-6 mb-3">
                <label for="image" class="form-label">
                  <i class="fas fa-image me-1"></i>Category Image
                </label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="image-preview" class="mt-2" style="display: none;">
                  <img id="preview-img" src="" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                </div>
              </div>
            </div>

            <div class="row">
              <!-- Status -->
              <div class="col-md-6 mb-3">
                <label for="status" class="form-label">
                  <i class="fas fa-toggle-on me-1"></i>Status <span class="text-danger">*</span>
                </label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                  <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                    <i class="fas fa-check-circle me-1"></i>Active
                  </option>
                  <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                    <i class="fas fa-times-circle me-1"></i>Inactive
                  </option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Show on Home Page -->
              <div class="col-md-6 mb-3">
                <label for="show_on_home" class="form-label">
                  <i class="fas fa-home me-1"></i>Display on Home Page <span class="text-danger">*</span>
                </label>
                <select name="show_on_home" id="show_on_home" class="form-select @error('show_on_home') is-invalid @enderror" required>
                  <option value="1" {{ old('show_on_home', '1') == '1' ? 'selected' : '' }}>
                    <i class="fas fa-eye me-1"></i>Show
                  </option>
                  <option value="0" {{ old('show_on_home') == '0' ? 'selected' : '' }}>
                    <i class="fas fa-eye-slash me-1"></i>Hide
                  </option>
                </select>
                <div class="form-text">Choose whether to display this category on the home page</div>
                @error('show_on_home')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-2 pt-3 border-top">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i>Save Category
              </button>
              <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>

<style>
.form-label {
  font-weight: 600;
  color: #495057;
}

.card {
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
}

.img-thumbnail {
  border: 2px solid #dee2e6;
}

.btn {
  border-radius: 0.375rem;
}
</style>
@endsection
