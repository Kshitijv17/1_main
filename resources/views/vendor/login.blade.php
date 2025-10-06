<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendor Login - HerbnHouse</title>
    
    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="auth-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="{{ route('user.home') }}" class="logo">
                        <h2 class="mb-0" style="color: var(--color3); font-weight: 600;">
                            <i class="fas fa-leaf me-2"></i>HerbnHouse
                        </h2>
                    </a>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('user.home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-home me-1"></i>Back to Store
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="auth-main">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-xl-10 col-lg-12">
                    <div class="auth-card">
                        <div class="row g-0">
                            <!-- Left Side - Branding -->
                            <div class="col-lg-6 auth-brand-side">
                                <div class="auth-brand-content">
                                    <div class="brand-logo">
                                        <i class="fas fa-store fa-4x mb-4"></i>
                                        <h2 class="brand-title">Vendor Portal</h2>
                                        <p class="brand-subtitle">Manage your store and grow your business</p>
                                    </div>
                                    
                                    <div class="features-list">
                                        <div class="feature-item">
                                            <i class="fas fa-chart-line"></i>
                                            <div>
                                                <h5>Sales Analytics</h5>
                                                <p>Track your sales performance and growth</p>
                                            </div>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-boxes"></i>
                                            <div>
                                                <h5>Inventory Management</h5>
                                                <p>Manage products and stock levels easily</p>
                                            </div>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-users"></i>
                                            <div>
                                                <h5>user Insights</h5>
                                                <p>Understand your users better</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Side - Login Form -->
                            <div class="col-lg-6 auth-form-side">
                                <div class="auth-form-content">
                                    <div class="form-header">
                                        <h3>Welcome Back!</h3>
                                        <p>Sign in to your vendor account</p>
                                    </div>


                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <form id="loginForm" action="{{ route('vendor.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="alert alert-danger d-none" id="loginError"></div>
                                        <div class="alert alert-success d-none" id="loginSuccess"></div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <input type="email" name="email" class="form-control" id="email" 
                                                       value="{{ old('email') }}" placeholder="Enter your email" required>
                                            </div>
                                            <div class="invalid-feedback" id="emailError"></div>
                                        </div>
                                        
                                        <div class="form-group mb-4">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <div class="input-group password-wrapper">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" name="password" class="form-control toggle-password-input" 
                                                       id="password" placeholder="Enter your password" required>
                                                <button class="btn btn-outline-secondary toggle-password-btn" type="button">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback" id="passwordError"></div>
                                        </div>
                                        
                                        <div class="form-group mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn">
                                            <span class="btn-text">
                                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                            </span>
                                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                                        </button>
                                    </form>

                                    <div class="auth-links">
                                        <div class="text-center">
                                            <p class="mb-2">Don't have a vendor account?</p>
                                            <a href="{{ route('vendor.register') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-user-plus me-1"></i>Register Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --color1: #8B4513;
            --color2: #A0522D;
            --color3: #2F4F4F;
            --primary-gradient: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
            --secondary-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--secondary-gradient);
            min-height: 100vh;
            color: #333;
        }

        .auth-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo h2 {
            font-family: 'Poppins', sans-serif;
        }

        .auth-main {
            padding: 2rem 0;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 600px;
        }

        .auth-brand-side {
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            position: relative;
        }

        .auth-brand-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .auth-brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .brand-logo i {
            color: rgba(255,255,255,0.9);
            margin-bottom: 1rem;
        }

        .brand-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 3rem;
        }

        .features-list {
            text-align: left;
            max-width: 400px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .feature-item i {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: rgba(255,255,255,0.9);
            min-width: 40px;
        }

        .feature-item h5 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .feature-item p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .auth-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .auth-form-content {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--color3);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #666;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--color3);
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #666;
        }

        .form-control {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--color1);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }

        .password-wrapper .form-control {
            border-right: none;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .toggle-password-btn {
            border-left: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--color1);
            color: var(--color1);
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background: var(--color1);
            border-color: var(--color1);
        }

        .auth-links {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .form-check-input:checked {
            background-color: var(--color1);
            border-color: var(--color1);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        .alert-success {
            background: #efe;
            color: #363;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-brand-side {
                display: none;
            }
            
            .brand-title {
                font-size: 2rem;
            }
            
            .auth-form-content {
                padding: 1rem;
            }
        }
    </style>

    <script>
        // Password toggle functionality
        document.querySelectorAll('.toggle-password-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = this.closest('.password-wrapper').querySelector('.toggle-password-input');
                const icon = this.querySelector('i');
                const isPassword = input.type === 'password';
                
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });

        // AJAX Form Submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const btn = $('#loginBtn');
            const btnText = btn.find('.btn-text');
            const spinner = btn.find('.spinner-border');
            
            // Clear previous errors
            $('.invalid-feedback').hide().text('');
            $('.form-control').removeClass('is-invalid');
            $('#loginError, #loginSuccess').addClass('d-none');
            
            // Show loading state
            btn.prop('disabled', true);
            btnText.html('<i class="fas fa-spinner fa-spin me-2"></i>Signing in...');
            spinner.removeClass('d-none');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#loginSuccess').removeClass('d-none').text('Login successful! Redirecting...');
                    setTimeout(function() {
                        window.location.href = '{{ route("vendor.dashboard") }}';
                    }, 1000);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON;
                    
                    if (xhr.status === 422 && errors.errors) {
                        $.each(errors.errors, function(field, messages) {
                            const input = $('#' + field);
                            const errorDiv = $('#' + field + 'Error');
                            
                            input.addClass('is-invalid');
                            errorDiv.show().text(messages[0]);
                        });
                    } else {
                        $('#loginError').removeClass('d-none').text(errors.message || 'Login failed. Please try again.');
                    }
                },
                complete: function() {
                    // Reset button state
                    btn.prop('disabled', false);
                    btnText.html('<i class="fas fa-sign-in-alt me-2"></i>Sign In');
                    spinner.addClass('d-none');
                }
            });
        });
    </script>
</body>
</html>