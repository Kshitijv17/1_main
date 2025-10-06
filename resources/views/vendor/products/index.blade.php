@extends('vendor.layout')

@section('page-title', 'Products')

@section('content')
<div class="mb-4 lg:mb-6">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
        <div class="flex-1">
            <h3 class="text-lg lg:text-2xl font-bold text-gray-900 mb-2">{{ $shop->name ?? 'Your Shop' }} - Products</h3>
            <p class="text-sm lg:text-base text-gray-600">Manage your shop's product inventory and listings.</p>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-xs lg:text-sm">
            <div class="text-gray-500">Shop ID: {{ $shop->id ?? 'N/A' }}</div>
            <div class="text-gray-500 flex items-center gap-2">Status: 
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ ($shop->is_active ?? false) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ($shop->is_active ?? false) ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Shop Statistics -->
@if(isset($stats))
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 lg:gap-4 mb-4 lg:mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-blue-600 text-lg lg:text-xl">inventory_2</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Total Products</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['total_products'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 lg:p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-green-600 text-lg lg:text-xl">check_circle</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Active</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['active_products'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 lg:p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-red-600 text-lg lg:text-xl">cancel</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Inactive</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['inactive_products'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 lg:p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-yellow-600 text-lg lg:text-xl">star</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Featured</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['featured_products'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 lg:p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-red-600 text-lg lg:text-xl">inventory</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Out of Stock</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['out_of_stock'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3 lg:p-4">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="flex-shrink-0 mb-2 lg:mb-0">
                <span class="material-symbols-outlined text-orange-600 text-lg lg:text-xl">warning</span>
            </div>
            <div class="lg:ml-3">
                <p class="text-xs lg:text-sm font-medium text-gray-500">Low Stock</p>
                <p class="text-sm lg:text-lg font-semibold text-gray-900">{{ $stats['low_stock'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 lg:gap-4 mb-4 lg:mb-6">
    <div class="relative flex-1 max-w-md w-full sm:w-auto">
        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm lg:text-base">search</span>
        <input type="text" placeholder="Search products..." class="w-full pl-9 lg:pl-10 pr-4 py-2 text-sm lg:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
    </div>
    <a href="{{ route('vendor.products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 lg:px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm lg:text-base whitespace-nowrap">
        <span class="material-symbols-outlined text-sm lg:text-base">add</span>
        <span class="hidden sm:inline">Add Product</span>
        <span class="sm:hidden">Add</span>
    </a>
</div>

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Category</th>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                    <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-3 lg:px-6 py-3 lg:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 lg:h-12 lg:w-12">
                                        @if($product->image)
                                            <img class="h-8 w-8 lg:h-12 lg:w-12 rounded-lg object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                                        @else
                                            <div class="h-8 w-8 lg:h-12 lg:w-12 rounded-lg bg-green-100 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-green-600 text-sm lg:text-base">spa</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-2 lg:ml-4 min-w-0 flex-1">
                                        <div class="text-xs lg:text-sm font-medium text-gray-900 truncate">{{ $product->title }}</div>
                                        <div class="sm:hidden text-xs text-gray-500">{{ $product->category->title ?? 'Uncategorized' }}</div>
                                        @if($product->is_featured)
                                            <div class="text-xs text-yellow-600 flex items-center mt-1">
                                                <span class="material-symbols-outlined text-xs mr-1">star</span>
                                                <span class="hidden lg:inline">Featured</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="text-xs lg:text-sm text-gray-900">{{ $product->category->title ?? 'Uncategorized' }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                @php
                                    $quantity = $product->quantity;
                                    $stockStatus = $product->stock_status;
                                    if ($stockStatus === 'out_of_stock' || $quantity == 0) {
                                        $stockClass = 'bg-red-100 text-red-800';
                                        $stockText = 'Out of Stock';
                                    } elseif ($quantity <= 10) {
                                        $stockClass = 'bg-yellow-100 text-yellow-800';
                                        $stockText = $quantity . ' units (Low)';
                                    } else {
                                        $stockClass = 'bg-green-100 text-green-800';
                                        $stockText = $quantity . ' units';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-1.5 lg:px-2.5 py-0.5 rounded-full text-xs font-medium {{ $stockClass }}">
                                    <span class="hidden lg:inline">{{ $stockText }}</span>
                                    <span class="lg:hidden">{{ $quantity }}</span>
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                <div class="text-xs lg:text-sm font-medium text-gray-900">
                                    @if($product->selling_price && $product->selling_price < $product->price)
                                        <div class="flex flex-col lg:flex-row lg:items-center">
                                            <span class="line-through text-gray-400 text-xs">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-green-600 lg:ml-1">${{ number_format($product->selling_price, 2) }}</span>
                                        </div>
                                    @else
                                        ${{ number_format($product->price, 2) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap hidden md:table-cell">
                                <button onclick="toggleStatus({{ $product->id }}, {{ $product->is_active ? 'true' : 'false' }})" 
                                        class="inline-flex items-center px-2 lg:px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ $product->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                        id="status-{{ $product->id }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-1 lg:space-x-2">
                                    <a href="{{ route('vendor.products.show', $product) }}" class="text-green-600 hover:text-green-900 p-1 rounded-lg hover:bg-green-50 transition-colors duration-200" title="View">
                                        <span class="material-symbols-outlined text-sm lg:text-base">visibility</span>
                                    </a>
                                    <a href="{{ route('vendor.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded-lg hover:bg-blue-50 transition-colors duration-200" title="Edit">
                                        <span class="material-symbols-outlined text-sm lg:text-base">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded-lg hover:bg-red-50 transition-colors duration-200" title="Delete">
                                            <span class="material-symbols-outlined text-sm lg:text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-4 lg:px-6 py-8 lg:py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-gray-400 text-4xl lg:text-6xl mb-3 lg:mb-4">inventory_2</span>
                                <h3 class="text-base lg:text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                <p class="text-sm lg:text-base text-gray-500 mb-4">Get started by adding your first product to {{ $shop->name ?? 'your shop' }}.</p>
                                <a href="{{ route('vendor.products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 lg:px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm lg:text-base">
                                    <span class="material-symbols-outlined text-sm lg:text-base">add</span>
                                    Add Your First Product
                                </a>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Additional Actions -->
<div class="mt-4 lg:mt-6 flex flex-col sm:flex-row gap-3 lg:gap-4">
    <a href="{{ route('vendor.products.bulk-upload-form') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 lg:px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm lg:text-base">
        <span class="material-symbols-outlined text-sm lg:text-base">upload</span>
        <span class="hidden sm:inline">Bulk Upload Products</span>
        <span class="sm:hidden">Bulk Upload</span>
    </a>
    <a href="{{ route('vendor.products.csv-template') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 lg:px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200 text-sm lg:text-base">
        <span class="material-symbols-outlined text-sm lg:text-base">download</span>
        <span class="hidden sm:inline">Download CSV Template</span>
        <span class="sm:hidden">Download CSV</span>
    </a>
</div>

<script>
function toggleStatus(productId, currentStatus) {
    fetch(`/vendor/products/${productId}/toggle-status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.getElementById(`status-${productId}`);
            const newStatus = data.is_active;
            
            // Update button text and classes
            button.textContent = data.status_text;
            button.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 ${
                newStatus 
                    ? 'bg-green-100 text-green-800 hover:bg-green-200' 
                    : 'bg-red-100 text-red-800 hover:bg-red-200'
            }`;
            
            // Update onclick attribute
            button.setAttribute('onclick', `toggleStatus(${productId}, ${newStatus})`);
            
            // Show success message
            showNotification('Product status updated successfully!', 'success');
        } else {
            showNotification('Failed to update product status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
