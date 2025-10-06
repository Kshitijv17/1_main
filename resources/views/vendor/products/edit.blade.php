@extends('vendor.layout')

@section('page-title', 'Edit Product')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Edit Product</h3>
            <p class="text-gray-600">Update your product information and settings</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('vendor.products.show', $product) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200">
                <span class="material-symbols-outlined">visibility</span>
                View Product
            </a>
            <a href="{{ route('vendor.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Products
            </a>
        </div>
    </div>
</div>

<!-- Error Messages -->
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <span class="material-symbols-outlined mr-2">error</span>
            <h6 class="font-semibold">Please fix the following errors:</h6>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <span class="material-symbols-outlined mr-2">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
@endif

<!-- Product Form -->
<form action="{{ route('vendor.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Product Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-green-600">edit</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Basic Information</h4>
                </div>
                
                <div class="space-y-4">
                    <!-- Product Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('title') border-red-300 @enderror" 
                               value="{{ old('title', $product->title) }}" 
                               placeholder="e.g., Organic Chamomile Tea"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Enter a descriptive title for your herbal product</p>
                    </div>

                    <!-- Product Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-300 @enderror"
                                  placeholder="Describe the benefits, ingredients, and uses of your herbal product...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('category_id') border-red-300 @enderror"
                                required>
                            <option value="">Select a category</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Information (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shop</label>
                        <div class="bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-green-600 mr-2">store</span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $shop->name ?? 'Your Shop' }}</p>
                                    <p class="text-sm text-gray-500">This product belongs to your shop</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="shop_id" value="{{ $product->shop_id }}">
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-blue-600">payments</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Pricing & Inventory</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Original Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Original Price ($) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" name="price" id="price" step="0.01" min="0"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('price') border-red-300 @enderror"
                                   value="{{ old('price', $product->price) }}"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Selling Price ($)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" name="selling_price" id="selling_price" step="0.01" min="0"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('selling_price') border-red-300 @enderror"
                                   value="{{ old('selling_price', $product->selling_price) }}"
                                   placeholder="0.00">
                        </div>
                        @error('selling_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Leave empty if same as original price</p>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('quantity') border-red-300 @enderror"
                               value="{{ old('quantity', $product->quantity) }}"
                               placeholder="0"
                               required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Status -->
                    <div>
                        <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock Status <span class="text-red-500">*</span>
                        </label>
                        <select name="stock_status" id="stock_status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('stock_status') border-red-300 @enderror"
                                required>
                            <option value="">Select stock status</option>
                            <option value="in_stock" {{ old('stock_status', $product->stock_status) === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="out_of_stock" {{ old('stock_status', $product->stock_status) === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('stock_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-purple-600">description</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Additional Details</h4>
                </div>
                
                <div class="space-y-4">
                    <!-- Features -->
                    <div>
                        <label for="features" class="block text-sm font-medium text-gray-700 mb-2">
                            Features
                        </label>
                        <textarea name="features" id="features" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('features') border-red-300 @enderror"
                                  placeholder="List the key features and benefits of your product...">{{ old('features', $product->features) }}</textarea>
                        @error('features')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Specifications -->
                    <div>
                        <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">
                            Specifications
                        </label>
                        <textarea name="specifications" id="specifications" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('specifications') border-red-300 @enderror"
                                  placeholder="Provide detailed specifications and technical details...">{{ old('specifications', $product->specifications) }}</textarea>
                        @error('specifications')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="discount_tag" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Tag
                            </label>
                            <input type="text" name="discount_tag" id="discount_tag"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('discount_tag') border-red-300 @enderror"
                                   value="{{ old('discount_tag', $product->discount_tag) }}"
                                   placeholder="e.g., 20% OFF, SALE">
                            @error('discount_tag')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_color" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Color
                            </label>
                            <input type="color" name="discount_color" id="discount_color"
                                   class="w-full h-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('discount_color') border-red-300 @enderror"
                                   value="{{ old('discount_color', $product->discount_color ?? '#FF0000') }}">
                            @error('discount_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Product Image -->
            @if($product->image)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-green-600">image</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Current Image</h4>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" 
                         class="w-full h-48 object-cover rounded-lg border border-gray-200">
                </div>
            </div>
            @endif

            <!-- Product Image Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-blue-600">upload</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">{{ $product->image ? 'Update Image' : 'Product Image' }}</h4>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $product->image ? 'Replace Image' : 'Upload Image' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('image') border-red-300 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Recommended: 800x600px, max 2MB</p>
                    </div>
                    
                    <div id="image-preview" class="hidden">
                        <img id="preview-img" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>
            </div>

            <!-- Product Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="material-symbols-outlined text-yellow-600">settings</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Product Settings</h4>
                </div>
                
                <div class="space-y-4">
                    <!-- Active Status -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-gray-700">Active Status</label>
                            <p class="text-sm text-gray-500">Make product visible to users</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <!-- Featured Status -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="is_featured" class="text-sm font-medium text-gray-700">Featured Product</label>
                            <p class="text-sm text-gray-500">Highlight this product</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="space-y-3">
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200 font-medium">
                        <span class="material-symbols-outlined">save</span>
                        Update Product
                    </button>
                    
                    <a href="{{ route('vendor.products.show', $product) }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200 font-medium">
                        <span class="material-symbols-outlined">visibility</span>
                        View Product
                    </a>
                    
                    <a href="{{ route('vendor.products.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200 font-medium">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Auto-update stock status based on quantity
document.getElementById('quantity').addEventListener('input', function() {
    const quantity = parseInt(this.value) || 0;
    const stockStatus = document.getElementById('stock_status');
    
    if (quantity === 0) {
        stockStatus.value = 'out_of_stock';
    } else if (stockStatus.value === 'out_of_stock' && quantity > 0) {
        stockStatus.value = 'in_stock';
    }
});
</script>
@endsection
