@extends('admin.layout')

@section('title', 'Supreme Command Center')
@section('page-title', 'Supreme Command Center')

@section('content')
<!-- Imperial Welcome Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--accent-color)); border: 1px solid var(--gold-color); color: white; position: relative; overflow: hidden;">
            <div class="card-body py-5 position-relative">
                <!-- Animated Background Elements -->
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                
                <div class="row align-items-center position-relative">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-4 flex-column flex-md-row text-center text-md-start">
                            <div class="me-md-4 mb-3 mb-md-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                                <i class="fas fa-crown fa-lg" style="color: var(--darker-color);"></i>
                            </div>
                            <div>
                                <h1 class="mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Welcome back, Supreme Administrator!</h1>
                                <p class="mb-0 opacity-90" style="font-size: 0.9rem; font-weight: 500;">You command the entire marketplace empire with absolute authority</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 gap-md-4 mt-4 flex-wrap justify-content-center justify-content-md-start">
                            <div class="text-center">
                                <div style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 1rem; padding: 1rem; backdrop-filter: blur(15px); min-width: 100px;">
                                    <h4 class="mb-1" style="color: var(--gold-color); font-weight: 700; font-size: 1.2rem;">{{ \App\Models\Shop::count() }}</h4>
                                    <small class="opacity-75" style="font-size: 0.75rem;">Kingdoms</small>
                                </div>
                            </div>
                            <div class="text-center">
                                <div style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 1rem; padding: 1rem; backdrop-filter: blur(15px); min-width: 100px;">
                                    <h4 class="mb-1" style="color: var(--gold-color); font-weight: 700; font-size: 1.2rem;">{{ \App\Models\Product::count() }}</h4>
                                    <small class="opacity-75" style="font-size: 0.75rem;">Assets</small>
                                </div>
                            </div>
                            <div class="text-center">
                                <div style="background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 1rem; padding: 1rem; backdrop-filter: blur(15px); min-width: 100px;">
                                    <h4 class="mb-1" style="color: var(--gold-color); font-weight: 700; font-size: 1.2rem;">{{ \App\Models\Order::count() }}</h4>
                                    <small class="opacity-75" style="font-size: 0.75rem;">Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center mt-4 mt-lg-0">
                        <div class="position-relative d-none d-lg-block">
                            <div style="width: 180px; height: 180px; background: var(--glass-bg); border: 2px solid var(--gold-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; backdrop-filter: blur(15px); box-shadow: 0 20px 40px rgba(245, 158, 11, 0.2);">
                                <i class="fas fa-chart-line" style="font-size: 3.5rem; color: var(--gold-color); opacity: 0.8;"></i>
                            </div>
                            <div class="position-absolute" style="top: 10px; right: 30px; width: 40px; height: 40px; background: linear-gradient(135deg, var(--success-color), #047857); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                                <i class="fas fa-trending-up" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Imperial Metrics Dashboard -->
<div class="row g-3 g-md-4 mb-4 mb-md-5">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border: 1px solid var(--gold-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -20px; right: -20px; width: 60px; height: 60px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-building" style="color: var(--darker-color); font-size: 1.2rem;"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--gold-color); font-size: 1.8rem;">{{ \App\Models\Shop::count() }}</h3>
                <p class="text-light mb-3" style="font-weight: 500; font-size: 0.9rem;">Merchant Kingdoms</p>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, var(--success-color), #047857); color: white; font-weight: 600;">
                        <i class="fas fa-arrow-up me-1"></i>+12% Growth
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(16, 185, 129, 0.05)); border: 1px solid var(--success-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -20px; right: -20px; width: 60px; height: 60px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--success-color), #047857); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-gem text-white" style="font-size: 1.2rem;"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--success-color); font-size: 1.8rem;">{{ \App\Models\Product::count() }}</h3>
                <p class="text-light mb-3" style="font-weight: 500; font-size: 0.9rem;">Imperial Assets</p>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); color: var(--darker-color); font-weight: 600;">
                        <i class="fas fa-arrow-up me-1"></i>+8% Expansion
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(59, 130, 246, 0.05)); border: 1px solid var(--info-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -20px; right: -20px; width: 60px; height: 60px; background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--info-color), #0e7490); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                    <i class="fas fa-scroll text-white" style="font-size: 1.2rem;"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--info-color); font-size: 1.8rem;">{{ \App\Models\Order::count() }}</h3>
                <p class="text-light mb-3" style="font-weight: 500; font-size: 0.9rem;">Royal Decrees</p>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, var(--warning-color), #d97706); color: var(--darker-color); font-weight: 600;">
                        <i class="fas fa-arrow-up me-1"></i>+24% Volume
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(99, 102, 241, 0.05)); border: 1px solid var(--accent-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -20px; right: -20px; width: 60px; height: 60px; background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);">
                    <i class="fas fa-users text-white" style="font-size: 1.2rem;"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--accent-color); font-size: 1.8rem;">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                <p class="text-light mb-3" style="font-weight: 500; font-size: 0.9rem;">Noble Merchants</p>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); color: white; font-weight: 600;">
                        <i class="fas fa-arrow-up me-1"></i>+5% Loyalty
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Supreme Command Management Grid -->
<div class="row g-3 g-md-4 mb-4 mb-md-5">
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.05)); border: 1px solid var(--gold-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-gem fa-lg" style="color: var(--darker-color);"></i>
                </div>
                <h5 class="mb-3" style="color: var(--gold-color); font-weight: 700; font-size: 1.1rem;">Product Empire</h5>
                <p class="text-light mb-4" style="opacity: 0.9; font-size: 0.85rem;">Command all products across your vast marketplace empire</p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600;">
                    <i class="fas fa-scepter me-2"></i>Rule Products
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(16, 185, 129, 0.05)); border: 1px solid var(--success-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--success-color), #047857); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-layer-group fa-2x text-white"></i>
                </div>
                <h5 class="mb-3" style="color: var(--success-color); font-weight: 700; font-size: 1.3rem;">Category Domains</h5>
                <p class="text-light mb-4" style="opacity: 0.9;">Organize your empire into strategic category domains</p>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-success w-100" style="font-weight: 600;">
                    <i class="fas fa-chess-rook me-2"></i>Manage Domains
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(59, 130, 246, 0.05)); border: 1px solid var(--info-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--info-color), #0e7490); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);">
                    <i class="fas fa-building fa-2x text-white"></i>
                </div>
                <h5 class="mb-3" style="color: var(--info-color); font-weight: 700; font-size: 1.3rem;">Merchant Kingdoms</h5>
                <p class="text-light mb-4" style="opacity: 0.9;">Oversee all merchant kingdoms under your rule</p>
                <a href="#" class="btn btn-info w-100" style="font-weight: 600;">
                    <i class="fas fa-eye me-2"></i>Survey Kingdoms
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(99, 102, 241, 0.05)); border: 1px solid var(--accent-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(99, 102, 241, 0.3);">
                    <i class="fas fa-scroll fa-2x text-white"></i>
                </div>
                <h5 class="mb-3" style="color: var(--accent-color); font-weight: 700; font-size: 1.3rem;">Order Chronicles</h5>
                <p class="text-light mb-4" style="opacity: 0.9;">Review all royal decrees and marketplace orders</p>
                <a href="#" class="btn w-100" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); color: white; font-weight: 600; border: none;">
                    <i class="fas fa-book me-2"></i>Read Chronicles
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(239, 68, 68, 0.05)); border: 1px solid var(--danger-color); position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(239, 68, 68, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--danger-color), #b91c1c); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(239, 68, 68, 0.3);">
                    <i class="fas fa-users-crown fa-2x text-white"></i>
                </div>
                <h5 class="mb-3" style="color: var(--danger-color); font-weight: 700; font-size: 1.3rem;">User Dominion</h5>
                <p class="text-light mb-4" style="opacity: 0.9;">Exercise supreme authority over all subjects</p>
                <a href="#" class="btn btn-danger w-100" style="font-weight: 600;">
                    <i class="fas fa-gavel me-2"></i>Rule Subjects
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="background: linear-gradient(135deg, var(--glass-bg), rgba(107, 114, 128, 0.05)); border: 1px solid #6b7280; position: relative; overflow: hidden;">
            <div class="card-body text-center position-relative">
                <div style="position: absolute; top: -30px; right: -30px; width: 80px; height: 80px; background: radial-gradient(circle, rgba(107, 114, 128, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div class="mb-4" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6b7280, #4b5563); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 12px 30px rgba(107, 114, 128, 0.3);">
                    <i class="fas fa-chart-line fa-2x text-white"></i>
                </div>
                <h5 class="mb-3" style="color: #6b7280; font-weight: 700; font-size: 1.3rem;">Imperial Analytics</h5>
                <p class="text-light mb-4" style="opacity: 0.9;">Analyze your empire's performance and growth</p>
                <a href="#" class="btn w-100" style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; font-weight: 600; border: none;">
                    <i class="fas fa-analytics me-2"></i>View Analytics
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Supreme Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, var(--glass-bg), rgba(245, 158, 11, 0.03)); border: 1px solid var(--glass-border);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; border-radius: 1.5rem 1.5rem 0 0;">
                <h5 class="mb-0" style="color: var(--darker-color); font-weight: 700; font-size: 1.2rem;">
                    <i class="fas fa-bolt me-2"></i>Supreme Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.products.create') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--gold-color), var(--gold-light)); border: none; color: var(--darker-color); font-weight: 600; padding: 1rem; border-radius: 1rem; min-height: 100px;">
                            <i class="fas fa-plus-circle fa-lg mb-2"></i>
                            <span style="font-size: 0.9rem;">Create Product</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="font-weight: 600; padding: 1rem; border-radius: 1rem; min-height: 100px;">
                            <i class="fas fa-plus fa-lg mb-2"></i>
                            <span style="font-size: 0.9rem;">Add Category</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.products.bulk-upload-form') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="font-weight: 600; padding: 1rem; border-radius: 1rem; min-height: 100px;">
                            <i class="fas fa-upload fa-lg mb-2"></i>
                            <span style="font-size: 0.9rem;">Bulk Upload</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('user.home') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center" target="_blank" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); border: none; color: white; font-weight: 600; padding: 1rem; border-radius: 1rem; min-height: 100px;">
                            <i class="fas fa-external-link-alt fa-lg mb-2"></i>
                            <span style="font-size: 0.9rem;">Preview Realm</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
