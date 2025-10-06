<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Our Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 800px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        .welcome-header {
            text-align: center;
            padding: 3rem 2rem 2rem;
        }

        .welcome-logo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 3rem;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            position: relative;
        }

        .welcome-logo::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.3;
            animation: pulse 3s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.1; }
            100% { transform: scale(1); opacity: 0.3; }
        }

        .welcome-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .quote-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(240, 147, 251, 0.1));
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .quote-text {
            font-size: 1.1rem;
            font-style: italic;
            color: #374151;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .auth-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .btn-auth-modal {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 1rem;
            padding: 0.875rem 2rem;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 140px;
        }

        .btn-auth-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth-modal:hover::before {
            left: 100%;
        }

        .btn-auth-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-auth-modal.register {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .btn-auth-modal.register:hover {
            box-shadow: 0 10px 25px rgba(240, 147, 251, 0.4);
        }

        .admin-section {
            padding: 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .admin-title {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .admin-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-admin {
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-admin:hover {
            transform: translateY(-1px);
        }

        .btn-vendor {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border-color: #f59e0b;
        }

        .btn-vendor:hover {
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .btn-super-admin {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-color: #ef4444;
        }

        .btn-super-admin:hover {
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .btn-guest {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-color: #10b981;
        }

        .btn-guest:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: white;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .welcome-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .quote-section {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .auth-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-auth-modal {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="welcome-card">
            <div class="welcome-header">
                <div class="welcome-logo">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h1 class="welcome-title">Welcome to Our Store</h1>
                <p class="welcome-subtitle">Your one-stop destination for amazing products and deals</p>
            </div>

            <div class="quote-section">
                @php
                    $quotes = [
                        "Success is not final, failure is not fatal: It is the courage to continue that counts.",
                        "Believe you can and you're halfway there.",
                        "The only way to do great work is to love what you do.",
                        "Don't watch the clock; do what it does. Keep going.",
                        "Your time is limited, so don't waste it living someone else's life."
                    ];
                    $quote = $quotes[array_rand($quotes)];
                @endphp

                <div class="quote-text text-center">
                    <i class="fas fa-quote-left me-2" style="color: #667eea;"></i>
                    {{ $quote }}
                    <i class="fas fa-quote-right ms-2" style="color: #667eea;"></i>
                </div>

                <div class="auth-buttons">
                    <button class="btn btn-auth-modal" onclick="openAuthModal('login')">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                    <button class="btn btn-auth-modal register" onclick="openAuthModal('register')">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </div>

                <div class="text-center">
                    <p class="mb-2" style="color: #6b7280; font-size: 0.9rem;">
                        New here? Create an account to unlock exclusive deals and faster checkout!
                    </p>
                    <a href="{{ route('user.home') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-shopping-bag me-1"></i>Continue to Store
                    </a>
                </div>
            </div>

            <div class="admin-section">
                <div class="admin-title">
                    <i class="fas fa-cog me-2"></i>Admin Access
                </div>
                <div class="admin-buttons">
                    <a href="{{ route('vendor.login') }}" class="btn btn-admin btn-vendor">
                        <i class="fas fa-store me-2"></i>Vendor
                    </a>
                    <a href="{{ route('admin.login') }}" class="btn btn-admin btn-super-admin">
                        <i class="fas fa-crown me-2"></i>Admin
                    </a>
                    <a href="{{ route('guest.login') }}" class="btn btn-admin btn-guest">
                        <i class="fas fa-user-secret me-2"></i>Browse as Guest
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the Auth Modal Component -->
    @include('components.auth-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
