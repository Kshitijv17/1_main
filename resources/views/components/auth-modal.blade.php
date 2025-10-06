<!-- Authentication Modal Component -->
<div class="modal fade" id="authModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered position-relative">
        <div class="modal-content p-0">
            <!-- Close Button -->
            <button class="modal-close-btn position-absolute" data-bs-dismiss="modal" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
            
            <div class="modal-body p-0">
                <div class="d-flex flex-lg-row flex-column align-items-center w-100">
                    <!-- IMAGE SECTION -->
                    <div class="col-lg-6 d-none d-lg-block p-0">
                        <div class="h-100 w-100">
                            <img src="/login_signup.png" class="w-100 h-100 object-fit-cover rounded-start" alt="Login Image" />
                        </div>
                    </div>
                    
                    <!-- FORM SECTION -->
                    <div class="col-lg-6 col-12 p-4">
                        <div class="login-signup-popup">
                            <!-- TABS -->
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link px-4 active" data-bs-toggle="tab" data-bs-target="#v-pills-login" type="button" role="tab" id="v-pills-login-tab">
                                        Login
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link px-4" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                                        Register
                                    </button>
                                </li>
                                </ul>
                            </div>
                            
                            <!-- TABS CONTENT -->
                            <div class="tab-content" id="productTabContent">
                                <!-- LOGIN TAB -->
                                <div class="tab-pane fade show active" id="v-pills-login" role="tabpanel">
                                    <form action="{{ route('user.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="loginEmail">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter your email" required />
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="loginPassword">Password <span class="text-danger">*</span></label>
                                                    <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                        <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" name="password" placeholder="Enter your password" required />
                                                        <span class="p-2 toggle-password-btn" type="button">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="themeButton2 mt-2">Login</button>
                                    </form>
                                </div>
                                
                                <!-- REGISTER TAB -->
                                <div class="tab-pane fade" id="register" role="tabpanel">
                                    <form action="{{ route('user.register.submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="regName">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="regName" name="name" placeholder="Enter your full name" required />
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="regMobile">Mobile Number <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="regMobile" name="contact" placeholder="Enter your mobile number" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" />
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="regEmail">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="regEmail" name="email" placeholder="Enter your email" required />
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="regPassword">Password <span class="text-danger">*</span></label>
                                                    <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                        <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" name="password" placeholder="Create a password" required />
                                                        <span class="p-2 toggle-password-btn" type="button">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="inputBox">
                                                    <label for="regPasswordConfirm">Confirm Password <span class="text-danger">*</span></label>
                                                    <div style="border: 1px solid #c7c7c7; border-radius: 5px;" class="input-group password-wrapper">
                                                        <input type="password" class="form-control w-auto font-14 border-0 toggle-password-input" name="password_confirmation" placeholder="Confirm your password" required />
                                                        <span class="p-2 toggle-password-btn" type="button">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="themeButton2 mt-2">Register</button>
                                    </form>
                                </div>
                            </div> <!-- tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Styles - Match Original Website */
.modal-content {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.font-26 {
    font-size: 1.625rem;
}

.object-fit-cover {
    object-fit: cover;
}

.rounded-start {
    border-top-left-radius: 1rem !important;
    border-bottom-left-radius: 1rem !important;
}

/* Form Styling */
.inputBox label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #333;
    font-size: 0.9rem;
}

.inputBox .form-control {
    border: 1px solid #c7c7c7;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 0.875rem;
}

.inputBox .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Theme Button */
.themeButton2 {
    background: linear-gradient(135deg, #8B4513, #A0522D);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
}

.themeButton2:hover {
    background: linear-gradient(135deg, #A0522D, #CD853F);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 69, 19, 0.3);
}

/* Password Wrapper */
.password-wrapper {
    display: flex;
    align-items: center;
}

.toggle-password-btn {
    cursor: pointer;
    color: #6c757d;
    border-left: 1px solid #c7c7c7;
}

.toggle-password-btn:hover {
    color: #495057;
}

/* Tab Styling - Exact Match to Original */
.nav-tabs {
    border-bottom: none;
    display: inline-flex;
    background: #f1f3f4;
    border-radius: 25px;
    padding: 4px;
    margin-bottom: 2rem;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    width: auto;
    margin-left: auto;
    margin-right: auto;
}

.nav-item {
    margin: 0;
}

.nav-tabs .nav-link {
    border: none;
    border-radius: 20px;
    color: #5f6368;
    font-weight: 500;
    font-size: 14px;
    padding: 8px 24px;
    margin: 0;
    background: transparent;
    transition: all 0.2s ease;
    white-space: nowrap;
    min-width: 80px;
    text-align: center;
}

.nav-tabs .nav-link.active {
    color: white;
    background-color: #1a1a1a;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    font-weight: 600;
}

.nav-tabs .nav-link:hover:not(.active) {
    color: #202124;
    background-color: rgba(0, 0, 0, 0.04);
}

.nav-tabs .nav-link:focus {
    box-shadow: none;
    outline: none;
}

/* Close Button Styling */
.modal-close-btn {
    top: 15px;
    right: 15px;
    z-index: 1070;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: #ffffff;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    border: 1px solid #e0e0e0;
}

.modal-close-btn:hover {
    background: #f5f5f5;
    color: #000;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.modal-close-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.modal-close-btn i {
    line-height: 1;
}
</style>

<script>
// Password Show/Hide Toggle
document.addEventListener('DOMContentLoaded', function() {
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
});

// Open modal function for compatibility
function openAuthModal(tab = 'login') {
    const modal = new bootstrap.Modal(document.getElementById('authModal'));
    modal.show();
    
    // Switch to specified tab
    if (tab === 'register') {
        document.querySelector('#register-tab').click();
    } else {
        document.querySelector('#v-pills-login-tab').click();
    }
}

// Handle form submissions with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Handle login form
    const loginForm = document.querySelector('#v-pills-login form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmission(this, 'login');
        });
    }
    
    // Handle register form
    const registerForm = document.querySelector('#register form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmission(this, 'register');
        });
    }
});

function handleFormSubmission(form, type) {
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...';
    
    // Clear previous error messages
    clearErrorMessages(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.redirected) {
            // Show success message
            showSuccessMessage(type === 'login' ? 'Login successful! Redirecting...' : 'Registration successful! Welcome!');
            
            // Close modal and redirect after a short delay
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('authModal'));
                if (modal) modal.hide();
                window.location.href = response.url;
            }, 1500);
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.errors) {
            // Show validation errors
            showFormErrors(form, data.errors);
        } else if (data && data.message) {
            showErrorMessage(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred. Please try again.');
    })
    .finally(() => {
        // Reset button state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
}

function showSuccessMessage(message) {
    // Create success toast
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed';
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i>${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function showErrorMessage(message) {
    // Create error toast
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white bg-danger border-0 position-fixed';
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle me-2"></i>${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function showFormErrors(form, errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            
            // Create or update error message
            let errorDiv = input.parentNode.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                input.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = messages[0];
        }
    }
}

function clearErrorMessages(form) {
    // Remove error classes and messages
    form.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
    });
    form.querySelectorAll('.invalid-feedback').forEach(error => {
        error.remove();
    });
}
</script>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = document.querySelectorAll('.auth-form-wrapper');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all forms
            forms.forEach(form => form.style.display = 'none');
            // Show target form
            document.getElementById(targetTab + 'Form').style.display = 'block';
        });
    });
});

// Password toggle functionality
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleButton = passwordInput.parentElement.querySelector('.password-toggle i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.classList.remove('fa-eye-slash');
        toggleButton.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        toggleButton.classList.remove('fa-eye');
        toggleButton.classList.add('fa-eye-slash');
    }
}

// Password strength checker
function checkPasswordStrength() {
    const password = document.getElementById('register_password').value;
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    
    let strength = 0;
    let text = '';
    let color = '';
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    switch (strength) {
        case 0:
        case 1:
            text = 'Very Weak';
            color = '#ef4444';
            break;
        case 2:
            text = 'Weak';
            color = '#f97316';
            break;
        case 3:
            text = 'Fair';
            color = '#eab308';
            break;
        case 4:
            text = 'Good';
            color = '#22c55e';
            break;
        case 5:
            text = 'Strong';
            color = '#16a34a';
            break;
    }
    
    strengthFill.style.width = (strength * 20) + '%';
    strengthFill.style.background = color;
    strengthText.textContent = password.length > 0 ? text : '';
}

// Open specific tab
function openAuthModal(tab = 'login') {
    const modal = new bootstrap.Modal(document.getElementById('authModal'));
    modal.show();
    
    // Switch to specified tab
    document.querySelector(`[data-tab="${tab}"]`).click();
}
</script>
<style>
.auth-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 1060;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.auth-modal-close:hover {
    background: rgba(255, 255, 255, 1);
    color: #374151;
    transform: scale(1.1);
}

/* Left Side - Food Background */
.auth-modal-left {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.food-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('/login_signup.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.food-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(254, 243, 199, 0.95) 0%, 
        rgba(253, 230, 138, 0.90) 25%,
        rgba(252, 211, 77, 0.85) 50%,
        rgba(245, 158, 11, 0.80) 75%,
        rgba(217, 119, 6, 0.75) 100%);
}

.food-background::after {
    content: '';
    position: absolute;
    top: 10%;
    left: 10%;
    width: 80px;
    height: 80px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.8) 0%, transparent 70%);
    border-radius: 50%;
    animation: float1 3s ease-in-out infinite;
}

.auth-brand-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 30%, rgba(245, 158, 11, 0.3) 0%, transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(217, 119, 6, 0.2) 0%, transparent 40%),
        radial-gradient(circle at 60% 20%, rgba(234, 179, 8, 0.25) 0%, transparent 35%);
}

@keyframes float1 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Right Side - Forms */
.auth-modal-right {
    background: white;
    height: 600px;
}

.auth-forms-container {
    padding: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Tab Navigation */
.auth-tabs {
    display: flex;
    margin-bottom: 2rem;
    background: #f9fafb;
    border-radius: 0.75rem;
    padding: 0.25rem;
    border: 1px solid #e5e7eb;
}

.auth-tab {
    flex: 1;
    background: none;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    color: #6b7280;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.auth-tab.active {
    background: #1f2937;
    color: white;
    box-shadow: 0 2px 8px rgba(31, 41, 55, 0.2);
}

.auth-tab:hover:not(.active) {
    color: #374151;
    background: #f3f4f6;
}

/* Form Styles */
.auth-form-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.auth-form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-form-header h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-family: 'Poppins', sans-serif;
}

.auth-form-header p {
    color: #6b7280;
    font-size: 0.95rem;
}

.auth-form {
    flex: 1;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: #b8860b;
    background: white;
    box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 0.25rem;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #374151;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.remember-me, .terms-agreement {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    color: #6b7280;
    cursor: pointer;
}

.remember-me input, .terms-agreement input {
    margin-right: 0.5rem;
}

.forgot-password, .terms-link {
    color: #667eea;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.forgot-password:hover, .terms-link:hover {
    text-decoration: underline;
}

.btn-auth-primary {
    width: 100%;
    background: #8B4513;
    border: none;
    border-radius: 0.5rem;
    padding: 0.875rem 1rem;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    cursor: pointer;
    margin-top: 1rem;
}

.btn-auth-primary:hover {
    background: #A0522D;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
}

.auth-divider {
    text-align: center;
    margin: 1.5rem 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e5e7eb;
}

.auth-divider span {
    background: white;
    color: #6b7280;
    padding: 0 1rem;
    font-size: 0.85rem;
}

.social-login {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.btn-social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    background: white;
    color: #374151;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-social:hover {
    border-color: #d1d5db;
    background: #f9fafb;
}

.btn-google:hover {
    border-color: #ea4335;
    color: #ea4335;
}

.btn-facebook:hover {
    border-color: #1877f2;
    color: #1877f2;
}

.guest-option {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.guest-option p {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.btn-guest {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-guest:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
}

/* Password Strength */
.password-strength {
    margin-top: 0.5rem;
}

.strength-bar {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.25rem;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

#strength-text {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Form Validation Styles */
.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

/* Toast Notifications */
.toast {
    min-width: 300px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.toast-body {
    font-weight: 500;
}

/* Loading Button State */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.1em;
}

/* Responsive */
@media (max-width: 991px) {
    .auth-modal-left {
        display: none;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .social-login {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .auth-forms-container {
        padding: 1.5rem;
    }
    
    .auth-tabs {
        flex-direction: column;
    }
    
    .auth-tab {
        margin-bottom: 0.25rem;
    }
    
    .toast {
        min-width: 250px;
        top: 10px !important;
        right: 10px !important;
    }
}
</style>
