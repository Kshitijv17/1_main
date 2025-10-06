@extends('user.layout')

@section('title', 'My Profile')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-breadcrumb">
                    <h2 class="dashboard-title">My Profile</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-content">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="dashboard-sidebar">
                    <div class="user-profile-card">
                        <div class="user-avatar">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=80&background=8B4513&color=fff" alt="User Avatar">
                        </div>
                        <div class="user-info">
                            <h5>{{ $user->name }}</h5>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <nav class="dashboard-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.my-account') }}">
                                    <i class="fas fa-tachometer-alt"></i> My Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.my-orders') }}">
                                    <i class="fas fa-shopping-bag"></i> My Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user-edit"></i> Change Address
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="alert('Wishlist feature coming soon!')">
                                    <i class="fas fa-heart"></i> Wishlist
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="alert('Password change feature coming soon!')">
                                    <i class="fas fa-key"></i> Change Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <!-- Logout Form -->
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="dashboard-main-content">
                    <div class="content-header">
                        <h3>Change Address</h3>
                    </div>
                    
                    <div class="address-form-container">
                        <form id="addressForm" method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fullName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" name="name" value="{{ $user->name ?? 'Herbandhouse' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mobileNumber" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="mobileNumber" name="phone" value="{{ $user->phone ?? '222222222' }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emailId" class="form-label">Email ID <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="emailId" name="email" value="{{ $user->email ?? 'dharasingh35@gmail.com' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" value="{{ $user->pincode ?? '333333' }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="state" name="state" value="{{ $user->state ?? 'rajasthan' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ $user->city ?? 'jaipur' }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="landmark" class="form-label">Landmark <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="landmark" name="landmark" value="{{ $user->landmark ?? 'ernehrehreheh' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="locality" class="form-label">Locality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="locality" name="locality" value="{{ $user->locality ?? 'erghregere' }}" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="4" required>{{ $user->address ?? 'drgreerherhreheh' }}</textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
.dashboard-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.dashboard-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #495057;
}

.dashboard-content {
    padding-bottom: 3rem;
}

.dashboard-sidebar {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.user-profile-card {
    background: #8B4513;
    color: white;
    padding: 2rem;
    text-align: center;
}

.user-avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.3);
    margin-bottom: 1rem;
}

.user-info h5 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.user-info p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.dashboard-nav {
    padding: 1rem 0;
}

.dashboard-nav .nav-link {
    color: #495057;
    padding: 0.75rem 1.5rem;
    border: none;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.dashboard-nav .nav-link:hover {
    background: #f8f9fa;
    color: #8B4513;
}

.dashboard-nav .nav-link.active {
    background: #8B4513;
    color: white;
}

.dashboard-nav .nav-link i {
    margin-right: 0.75rem;
    width: 20px;
}

.dashboard-main-content {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 2rem;
}

.content-header h3 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.address-form-container .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.address-form-container .form-control {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 0.75rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.address-form-container .form-control:focus {
    border-color: #8B4513;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-primary {
    background-color: #8B4513;
    border-color: #8B4513;
    padding: 0.75rem 2rem;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #6d3410;
    border-color: #6d3410;
}

.text-danger {
    color: #dc3545 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1rem 0;
    }
    
    .dashboard-main-content {
        padding: 1rem;
    }
    
    .user-profile-card {
        padding: 1.5rem;
    }
}
</style>

<script>
// Form submission handling with AJAX
document.getElementById('addressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    // Prepare form data
    const formData = new FormData(form);
    
    // Add AJAX header
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            form.insertBefore(alertDiv, form.firstChild);
            
            // Auto-hide alert after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(error => {
        // Show error message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            Error: ${error.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        form.insertBefore(alertDiv, form.firstChild);
        
        // Auto-hide alert after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endsection
