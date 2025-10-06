@extends('vendor.layout')

@section('content')
<!-- Header Section -->
    <div class="mb-6 lg:mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-3 lg:space-x-4">
                <div class="p-2 lg:p-3 bg-green-100 dark:bg-green-900 rounded-xl">
                    <span class="material-symbols-outlined text-xl lg:text-2xl text-green-600 dark:text-green-400">storefront</span>
                </div>
                <div>
                    <h1 class="text-xl lg:text-3xl font-bold text-gray-900 font-display">Manage Your Shop</h1>
                    <p class="text-sm lg:text-base text-gray-600 mt-1">Update your shop information and settings</p>
                </div>
            </div>
            <a href="{{ route('vendor.dashboard') }}" 
               class="inline-flex items-center px-3 lg:px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 text-sm lg:text-base">
                <span class="material-symbols-outlined mr-2 text-sm lg:text-lg">arrow_back</span>
                <span class="hidden sm:inline">Back to Dashboard</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-8">
        <!-- Main Form -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-xl lg:rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <form action="{{ route('vendor.shop.update') }}" method="POST" enctype="multipart/form-data" class="p-4 lg:p-8">
                    @csrf @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="mb-6 lg:mb-8">
                        <h3 class="text-lg lg:text-xl font-semibold text-gray-900 mb-4 lg:mb-6 flex items-center">
                            <span class="material-symbols-outlined mr-2 lg:mr-3 text-green-600 dark:text-green-400 text-lg lg:text-xl">info</span>
                            Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                            <!-- Shop Name -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center text-xs lg:text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400 text-sm lg:text-base">store</span>
                                    Shop Name
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="w-full px-3 lg:px-4 py-2 lg:py-3 bg-white border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 text-sm lg:text-base @error('name') border-red-500 @enderror"
                                       value="{{ old('name', $shop->name) }}" 
                                       placeholder="Enter your shop name"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Shop Email -->
                            <div class="space-y-2">
                                <label for="email" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">email</span>
                                    Shop Email
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 @error('email') border-red-500 @enderror"
                                       value="{{ old('email', $shop->email) }}" 
                                       placeholder="shop@example.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Shop Description -->
                        <div class="mt-6 space-y-2">
                            <label for="description" class="flex items-center text-sm font-semibold text-gray-900">
                                <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">description</span>
                                Shop Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4" 
                                      class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 @error('description') border-red-500 @enderror"
                                      placeholder="Describe your shop and what you sell...">{{ old('description', $shop->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-green-600 dark:text-green-400">contact_phone</span>
                            Contact Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div class="space-y-2">
                                <label for="phone" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">phone</span>
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 @error('phone') border-red-500 @enderror"
                                       value="{{ old('phone', $shop->phone) }}" 
                                       placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="space-y-2">
                                <label for="website" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">language</span>
                                    Website URL
                                </label>
                                <input type="url" 
                                       name="website" 
                                       id="website" 
                                       class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 @error('website') border-red-500 @enderror"
                                       value="{{ old('website', $shop->website) }}" 
                                       placeholder="https://yourshop.com">
                                @error('website')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-6 space-y-2">
                            <label for="address" class="flex items-center text-sm font-semibold text-gray-900">
                                <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">location_on</span>
                                Shop Address
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3" 
                                      class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400 @error('address') border-red-500 @enderror"
                                      placeholder="Enter your shop's physical address...">{{ old('address', $shop->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Brand Assets -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-green-600 dark:text-green-400">palette</span>
                            Brand Assets
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo Upload -->
                            <div class="space-y-2">
                                <label for="logo" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">account_circle</span>
                                    Shop Logo
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="logo" 
                                           id="logo" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('logo') border-red-500 @enderror"
                                           accept="image/*">
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-green-500 dark:hover:border-green-400 transition-colors duration-200 cursor-pointer bg-white">
                                        @if($shop->logo)
                                            <img src="{{ asset('storage/' . $shop->logo) }}" alt="Current Logo" 
                                                 class="mx-auto mb-2 rounded-lg shadow-md" style="max-width: 100px; max-height: 100px;">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Click to change logo</p>
                                        @else
                                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-2xl text-green-600 dark:text-green-400">add_photo_alternate</span>
                                            </div>
                                            <p class="text-gray-700 font-medium">Upload Logo</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                                        @endif
                                    </div>
                                </div>
                                @error('logo')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Banner Upload -->
                            <div class="space-y-2">
                                <label for="banner" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">image</span>
                                    Shop Banner
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="banner" 
                                           id="banner" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('banner') border-red-500 @enderror"
                                           accept="image/*">
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-green-500 dark:hover:border-green-400 transition-colors duration-200 cursor-pointer bg-white">
                                        @if($shop->banner)
                                            <img src="{{ asset('storage/' . $shop->banner) }}" alt="Current Banner" 
                                                 class="mx-auto mb-2 rounded-lg shadow-md" style="max-width: 200px; max-height: 100px;">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Click to change banner</p>
                                        @else
                                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-2xl text-green-600 dark:text-green-400">landscape</span>
                                            </div>
                                            <p class="text-gray-700 font-medium">Upload Banner</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PNG, JPG up to 5MB</p>
                                        @endif
                                    </div>
                                </div>
                                @error('banner')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-green-600 dark:text-green-400">settings</span>
                            Shop Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Commission Rate -->
                            <div class="space-y-2">
                                <label for="commission_rate" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">percent</span>
                                    Commission Rate (%)
                                </label>
                                <input type="number" 
                                       name="commission_rate" 
                                       id="commission_rate" 
                                       class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 border border-gray-300 rounded-xl text-gray-700 cursor-not-allowed @error('commission_rate') border-red-500 @enderror"
                                       value="{{ old('commission_rate', $shop->commission_rate) }}" 
                                       min="0" max="100" step="0.01" readonly>
                                <p class="text-xs text-gray-500 dark:text-gray-400">This rate is set by the marketplace administrator</p>
                                @error('commission_rate')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Shop Status -->
                            <div class="space-y-2">
                                <label for="is_active" class="flex items-center text-sm font-semibold text-gray-900">
                                    <span class="material-symbols-outlined mr-2 text-green-600 dark:text-green-400">toggle_on</span>
                                    Shop Status
                                </label>
                                <select name="is_active" 
                                        id="is_active" 
                                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 @error('is_active') border-red-500 @enderror">
                                    <option value="1" {{ old('is_active', $shop->is_active) == 1 ? 'selected' : '' }}>✅ Active</option>
                                    <option value="0" {{ old('is_active', $shop->is_active) == 0 ? 'selected' : '' }}>❌ Inactive</option>
                                </select>
                                @error('is_active')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <span class="material-symbols-outlined mr-1 text-sm">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('vendor.dashboard') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                            <span class="material-symbols-outlined mr-2">close</span>
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span class="material-symbols-outlined mr-2">save</span>
                            Update Shop
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="xl:col-span-1 space-y-6">
            <!-- Shop Statistics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <span class="material-symbols-outlined mr-3 text-green-600 dark:text-green-400">analytics</span>
                    Shop Statistics
                </h3>
                
                <div class="space-y-4">
                    <!-- Total Products -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-600 dark:text-blue-400 text-sm font-medium">Total Products</p>
                                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $shop->stats['total_products'] }}</p>
                            </div>
                            <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">inventory</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Products -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-600 dark:text-green-400 text-sm font-medium">Active Products</p>
                                <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $shop->stats['active_products'] }}</p>
                            </div>
                            <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg">
                                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-600 dark:text-purple-400 text-sm font-medium">Total Orders</p>
                                <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $shop->stats['total_orders'] }}</p>
                            </div>
                            <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg">
                                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">receipt_long</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-amber-600 dark:text-amber-400 text-sm font-medium">Total Revenue</p>
                                <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">${{ number_format($shop->stats['total_revenue'], 2) }}</p>
                            </div>
                            <div class="p-2 bg-amber-100 dark:bg-amber-800 rounded-lg">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400">payments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <span class="material-symbols-outlined mr-3 text-green-600 dark:text-green-400">flash_on</span>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('vendor.products.index') }}" 
                       class="w-full inline-flex items-center px-4 py-3 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">
                        <span class="material-symbols-outlined mr-3">inventory</span>
                        Manage Products
                    </a>
                    
                    <a href="{{ route('vendor.orders.index') }}" 
                       class="w-full inline-flex items-center px-4 py-3 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-200 dark:hover:bg-purple-800 transition-colors duration-200">
                        <span class="material-symbols-outlined mr-3">receipt_long</span>
                        View Orders
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Please enter a shop name.');
            document.getElementById('name').focus();
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="material-symbols-outlined mr-2 animate-spin">refresh</span>Updating...';
        submitBtn.disabled = true;
        
        // Re-enable button after 5 seconds as fallback
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
});
</script>
@endsection
