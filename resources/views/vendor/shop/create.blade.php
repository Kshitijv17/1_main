<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Setup Your Shop - HerbnHouse</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-purple: #8B5FBF;
      --secondary-purple: #A855F7;
      --light-purple: #C084FC;
      --neutral-50: #FAFAF9;
      --neutral-100: #F5F5F4;
      --neutral-200: #E7E5E4;
      --neutral-300: #D6D3D1;
      --neutral-400: #A8A29E;
      --neutral-500: #78716C;
      --neutral-600: #57534E;
      --neutral-700: #44403C;
      --neutral-800: #292524;
      --neutral-900: #1C1917;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #8B5FBF 0%, #A855F7 50%, #C084FC 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      color: var(--neutral-700);
      line-height: 1.6;
    }

    .setup-container {
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }

    .setup-header {
      text-align: center;
      margin-bottom: 3rem;
      color: white;
    }

    .setup-header .icon {
      width: 80px;
      height: 80px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .setup-header h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .setup-header p {
      font-size: 1.1rem;
      opacity: 0.9;
      font-weight: 400;
    }

    .form-card {
      background: white;
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-content {
      padding: 3rem;
    }

    .section-header {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--neutral-100);
    }

    .section-header .icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      color: white;
      font-size: 1.1rem;
    }

    .section-header h3 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--neutral-800);
      margin: 0;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: 500;
      color: var(--neutral-700);
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      display: block;
    }

    .form-control {
      border: 2px solid var(--neutral-200);
      border-radius: 12px;
      padding: 0.875rem 1rem;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: var(--neutral-50);
      color: var(--neutral-700);
    }

    .form-control:focus {
      border-color: var(--primary-purple);
      box-shadow: 0 0 0 3px rgba(139, 95, 191, 0.1);
      background: white;
      outline: none;
    }

    .form-control::placeholder {
      color: var(--neutral-400);
      font-weight: 400;
    }

    textarea.form-control {
      resize: vertical;
      min-height: 120px;
    }

    .file-upload {
      position: relative;
      display: block;
    }

    .file-upload input[type="file"] {
      position: absolute;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }

    .file-upload-label {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      border: 2px dashed var(--neutral-300);
      border-radius: 12px;
      background: var(--neutral-50);
      transition: all 0.3s ease;
      cursor: pointer;
      text-align: center;
    }

    .file-upload:hover .file-upload-label {
      border-color: var(--primary-purple);
      background: rgba(139, 95, 191, 0.05);
    }

    .file-upload-content {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .file-upload-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }

    .file-upload-text {
      color: var(--neutral-600);
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    .file-upload-hint {
      color: var(--neutral-400);
      font-size: 0.875rem;
    }

    .submit-section {
      margin-top: 3rem;
      padding-top: 2rem;
      border-top: 2px solid var(--neutral-100);
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
      border: none;
      border-radius: 12px;
      padding: 1rem 3rem;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(139, 95, 191, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(139, 95, 191, 0.4);
      background: linear-gradient(135deg, #7A4FA3, #9333EA);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .submit-hint {
      margin-top: 1rem;
      color: var(--neutral-500);
      font-size: 0.9rem;
    }

    .alert {
      border: none;
      border-radius: 12px;
      padding: 1rem 1.5rem;
      margin-bottom: 2rem;
    }

    .alert-danger {
      background: #FEF2F2;
      color: #DC2626;
      border-left: 4px solid #DC2626;
    }

    .text-danger {
      color: #DC2626 !important;
    }

    .invalid-feedback {
      color: #DC2626;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

    .form-control.is-invalid {
      border-color: #DC2626;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .setup-container {
        padding: 1rem;
      }

      .form-content {
        padding: 2rem 1.5rem;
      }

      .setup-header h1 {
        font-size: 2rem;
      }

      .section-header {
        flex-direction: column;
        text-align: center;
      }

      .section-header .icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
      }
    }
  </style>
</head>
<body>

<div class="setup-container">
  <!-- Header Section -->
  <div class="setup-header">
    <div class="icon">
      <i class="fas fa-store fa-2x" style="color: white;"></i>
    </div>
    <h1>Setup Your Shop</h1>
    <p>Welcome {{ auth()->user()->name }}! Let's create your online shop to start selling.</p>
  </div>

  <!-- Form Card -->
  <div class="form-card">
    <div class="form-content">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0 list-unstyled">
            @foreach ($errors->all() as $error)
              <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('vendor.shop.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
          <!-- Basic Information Section -->
          <div class="col-lg-6">
            <div class="section-header">
              <div class="icon">
                <i class="fas fa-info-circle"></i>
              </div>
              <h3>Basic Information</h3>
            </div>
            
            <div class="form-group">
              <label for="name" class="form-label">Shop Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                     value="{{ old('name') }}" required placeholder="Enter your shop name">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="description" class="form-label">Shop Description</label>
              <textarea name="description" id="description" 
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Describe what your shop sells...">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="address" class="form-label">Shop Address</label>
              <textarea name="address" id="address" 
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Enter your shop address..." style="min-height: 100px;">{{ old('address') }}</textarea>
              @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Contact Information Section -->
          <div class="col-lg-6">
            <div class="section-header">
              <div class="icon">
                <i class="fas fa-phone"></i>
              </div>
              <h3>Contact Information</h3>
            </div>
            
            <div class="form-group">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                     value="{{ old('phone') }}" placeholder="Enter phone number">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email" class="form-label">Shop Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                     value="{{ old('email') }}" placeholder="shop@example.com">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="website" class="form-label">Website URL</label>
              <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" 
                     value="{{ old('website') }}" placeholder="https://yourwebsite.com">
              @error('website')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Shop Images Section -->
        <div class="section-header mt-4">
          <div class="icon">
            <i class="fas fa-images"></i>
          </div>
          <h3>Shop Images</h3>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-label">Shop Logo</label>
              <div class="file-upload">
                <input type="file" name="logo" id="logo" accept="image/*" class="@error('logo') is-invalid @enderror">
                <div class="file-upload-label">
                  <div class="file-upload-content">
                    <div class="file-upload-icon">
                      <i class="fas fa-image"></i>
                    </div>
                    <div class="file-upload-text">Choose File</div>
                    <div class="file-upload-hint">Upload a square logo (recommended: 200x200px)</div>
                  </div>
                </div>
              </div>
              @error('logo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-label">Shop Banner</label>
              <div class="file-upload">
                <input type="file" name="banner" id="banner" accept="image/*" class="@error('banner') is-invalid @enderror">
                <div class="file-upload-label">
                  <div class="file-upload-content">
                    <div class="file-upload-icon">
                      <i class="fas fa-panorama"></i>
                    </div>
                    <div class="file-upload-text">Choose File</div>
                    <div class="file-upload-hint">Upload a banner image (recommended: 1200x400px)</div>
                  </div>
                </div>
              </div>
              @error('banner')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Submit Section -->
        <div class="submit-section">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-store me-2"></i>Create My Shop
          </button>
          <div class="submit-hint">
            You can update these details later from your dashboard
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Enhanced file upload functionality
function setupFileUpload(inputId, labelSelector) {
  const input = document.getElementById(inputId);
  const label = input.closest('.file-upload').querySelector('.file-upload-label');
  const textElement = label.querySelector('.file-upload-text');
  const hintElement = label.querySelector('.file-upload-hint');
  
  input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      // Update the label text
      textElement.textContent = file.name;
      textElement.style.color = 'var(--primary-purple)';
      textElement.style.fontWeight = '600';
      
      // Update the hint
      const fileSize = (file.size / 1024 / 1024).toFixed(2);
      hintElement.textContent = `Selected: ${fileSize} MB`;
      
      // Add visual feedback
      label.style.borderColor = 'var(--primary-purple)';
      label.style.background = 'rgba(139, 95, 191, 0.05)';
      
      // Preview functionality (optional)
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          console.log(`${inputId} selected:`, file.name);
          // You can add image preview here if needed
        };
        reader.readAsDataURL(file);
      }
    } else {
      // Reset to original state
      textElement.textContent = 'Choose File';
      textElement.style.color = '';
      textElement.style.fontWeight = '';
      hintElement.textContent = inputId === 'logo' ? 
        'Upload a square logo (recommended: 200x200px)' : 
        'Upload a banner image (recommended: 1200x400px)';
      label.style.borderColor = '';
      label.style.background = '';
    }
  });
  
  // Drag and drop functionality
  label.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = 'var(--primary-purple)';
    this.style.background = 'rgba(139, 95, 191, 0.1)';
  });
  
  label.addEventListener('dragleave', function(e) {
    e.preventDefault();
    if (!input.files[0]) {
      this.style.borderColor = '';
      this.style.background = '';
    }
  });
  
  label.addEventListener('drop', function(e) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      input.files = files;
      input.dispatchEvent(new Event('change'));
    }
  });
}

// Initialize file uploads
document.addEventListener('DOMContentLoaded', function() {
  setupFileUpload('logo', '.file-upload-label');
  setupFileUpload('banner', '.file-upload-label');
  
  // Form validation enhancement
  const form = document.querySelector('form');
  const submitBtn = document.querySelector('.btn-primary');
  
  form.addEventListener('submit', function(e) {
    // Add loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Your Shop...';
    submitBtn.disabled = true;
    
    // You can add additional validation here if needed
  });
  
  // Auto-resize textareas
  document.querySelectorAll('textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });
  });
});

// Smooth scroll to error if any
if (document.querySelector('.alert-danger')) {
  document.querySelector('.alert-danger').scrollIntoView({ 
    behavior: 'smooth', 
    block: 'center' 
  });
}
</script>

</body>
</html>
