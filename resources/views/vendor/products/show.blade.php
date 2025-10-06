@extends('vendor.layout')

@section('content')
<div class="p-6">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div class="flex items-center mb-4 sm:mb-0">
      <span class="material-symbols-outlined text-gray-600 mr-3 text-2xl">visibility</span>
      <h1 class="text-2xl font-bold text-gray-800">Product Details</h1>
    </div>
    <div class="flex flex-col sm:flex-row gap-2">
      <a href="{{ route('vendor.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors">
        <span class="material-symbols-outlined mr-2 text-sm">edit</span>
        Edit Product
      </a>
      <a href="{{ route('vendor.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
        <span class="material-symbols-outlined mr-2 text-sm">arrow_back</span>
        Back to Products
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Product Images Section -->
    <div class="xl:col-span-2">
      <div class="bg-white rounded-lg border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <span class="material-symbols-outlined mr-2 text-gray-600">image</span>
            Product Images
          </h2>
        </div>
        <div class="p-6">
          @if($product->image)
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                <span class="material-symbols-outlined mr-2 text-blue-500 text-sm">star</span>
                Main Image
              </h3>
              <div class="text-center">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="max-h-80 rounded-lg shadow-md cursor-pointer hover:shadow-lg transition-shadow mx-auto" onclick="openImageModal('{{ asset('storage/' . $product->image) }}', 'Main Product Image')">
              </div>
            </div>
          @endif

          @if($product->images->count() > 0)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-medium text-gray-700 flex items-center">
                  <span class="material-symbols-outlined mr-2 text-green-500 text-sm">collections</span>
                  Additional Images
                </h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $product->images->count() }} images</span>
              </div>
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($product->images as $image)
                  <div class="relative group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Additional product image {{ $loop->iteration }}" class="w-full h-32 object-cover rounded-lg shadow cursor-pointer hover:shadow-md transition-shadow" onclick="openImageModal('{{ asset('storage/' . $image->image_path) }}', 'Additional Image {{ $loop->iteration }}')">
                    <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                      {{ $loop->iteration }}
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white text-xs p-2 rounded-b-lg opacity-0 group-hover:opacity-100 transition-opacity">
                      <span class="material-symbols-outlined text-xs mr-1">zoom_in</span>Click to view
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="mt-3 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center">
                  <span class="material-symbols-outlined mr-1 text-xs">info</span>
                  Click on any image to view it in full size
                </p>
              </div>
            </div>
          @endif

          @if(!$product->image && $product->images->count() == 0)
            <div class="text-center text-gray-500 py-12">
              <span class="material-symbols-outlined text-6xl mb-4 text-gray-300">image</span>
              <h3 class="text-lg font-medium mb-2">No Images Available</h3>
              <p class="text-sm">This product doesn't have any uploaded images.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Product Information Sidebar -->
    <div class="space-y-6">
      <!-- Product Information -->
      <div class="bg-white rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <span class="material-symbols-outlined mr-2 text-gray-600">info</span>
            Product Information
          </h2>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-gray-500">Title</label>
              <p class="text-gray-900 font-semibold">{{ $product->title }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Description</label>
              <div class="text-gray-900">
                @if($product->description)
                  {!! nl2br(e($product->description)) !!}
                @else
                  <span class="text-gray-400">No description</span>
                @endif
              </div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Original Price</label>
              <p class="text-xl font-bold text-blue-600">₹{{ number_format($product->price, 2) }}</p>
            </div>
            @if($product->selling_price)
            <div>
              <label class="text-sm font-medium text-gray-500">Selling Price</label>
              <p class="text-xl font-bold text-green-600">₹{{ number_format($product->selling_price, 2) }}</p>
            </div>
            @endif
            <div>
              <label class="text-sm font-medium text-gray-500">Stock Quantity</label>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $product->quantity }} units
              </span>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Stock Status</label>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock_status === 'in_stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $product->stock_status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
              </span>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Product Status</label>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                <span class="material-symbols-outlined mr-1 text-xs">{{ $product->is_active ? 'check_circle' : 'cancel' }}</span>
                {{ $product->is_active ? 'Active' : 'Inactive' }}
              </span>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Category</label>
              @if($product->category)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $product->category->title }}</span>
              @else
                <span class="text-gray-400">No category</span>
              @endif
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Created</label>
              <p class="text-gray-900">{{ $product->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Updated</label>
              <p class="text-gray-900">{{ $product->updated_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <span class="material-symbols-outlined mr-2 text-gray-600">bolt</span>
            Quick Actions
          </h3>
        </div>
        <div class="p-6">
          <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('vendor.products.edit', $product) }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors">
              <span class="material-symbols-outlined mr-2 text-sm">edit</span>
              Edit
            </a>
            <button onclick="confirmDelete()" class="inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
              <span class="material-symbols-outlined mr-2 text-sm">delete</span>
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  @if($product->features)
  <div class="bg-white rounded-lg border border-gray-200 mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
      <h2 class="text-lg font-semibold text-green-800 flex items-center">
        <span class="material-symbols-outlined mr-2 text-green-600">star</span>
        Product Features
      </h2>
    </div>
    <div class="p-6">
      <div class="prose max-w-none">
        {!! $product->features !!}
      </div>
    </div>
  </div>
  @endif

  <!-- Specifications Section -->
  @if($product->specifications)
  <div class="bg-white rounded-lg border border-gray-200 mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
      <h2 class="text-lg font-semibold text-blue-800 flex items-center">
        <span class="material-symbols-outlined mr-2 text-blue-600">settings</span>
        Technical Specifications
      </h2>
    </div>
    <div class="p-6">
      <div class="prose max-w-none">
        {!! $product->specifications !!}
      </div>
    </div>
  </div>
  @endif

  <!-- Discount Information -->
  @if($product->discount_tag)
  <div class="bg-white rounded-lg border border-gray-200 mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
      <h2 class="text-lg font-semibold text-yellow-800 flex items-center">
        <span class="material-symbols-outlined mr-2 text-yellow-600">local_offer</span>
        Discount Information
      </h2>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="text-sm font-medium text-gray-700 mb-3">Discount Tag</h3>
          <div class="flex items-center space-x-3">
            <span class="px-3 py-2 text-sm font-medium text-white rounded-lg border-2 border-black" style="background-color: {{ $product->discount_color }};">
              {{ $product->discount_tag }}
            </span>
            <span class="text-sm text-gray-500">Color: {{ $product->discount_color }}</span>
          </div>
        </div>
        <div>
          @if($product->selling_price)
          <h3 class="text-sm font-medium text-gray-700 mb-3">Pricing Comparison</h3>
          <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="line-through text-gray-500 text-sm">₹{{ number_format($product->price, 2) }}</div>
            <div class="text-green-600 font-bold text-xl">₹{{ number_format($product->selling_price, 2) }}</div>
            <div class="text-green-600 text-sm">
              Save ₹{{ number_format($product->price - $product->selling_price, 2) }}
              ({{ number_format((($product->price - $product->selling_price) / $product->price) * 100, 1) }}% off)
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- All Product Images Gallery -->
  @if($product->images->count() > 0)
    <div class="bg-white rounded-lg border border-gray-200 mt-6">
      <div class="px-6 py-4 border-b border-gray-200 bg-green-50 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-green-800 flex items-center">
          <span class="material-symbols-outlined mr-2 text-green-600">photo_library</span>
          All Product Images Gallery
        </h2>
        <div class="flex space-x-2">
          <span class="bg-white text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded-full border">{{ $product->images->count() }} additional</span>
          @if($product->image)
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">+ 1 main</span>
          @endif
        </div>
      </div>
      <div class="p-6">
        <div class="space-y-8">
          <!-- Main Image -->
          @if($product->image)
            <div class="text-center">
              <h3 class="text-blue-600 font-medium mb-4 flex items-center justify-center">
                <span class="material-symbols-outlined mr-2 text-sm">star</span>
                Main Product Image
              </h3>
              <img src="{{ asset('storage/' . $product->image) }}" alt="Main product image" class="max-h-64 rounded-lg shadow-md cursor-pointer hover:shadow-lg transition-shadow mx-auto" onclick="openImageModal('{{ asset('storage/' . $product->image) }}', 'Main Product Image')">
            </div>
          @endif

          <!-- Additional Images -->
          <div>
            <h3 class="text-green-600 font-medium mb-4 flex items-center">
              <span class="material-symbols-outlined mr-2 text-sm">collections</span>
              Additional Product Images ({{ $product->images->count() }})
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              @foreach($product->images as $image)
                <div class="text-center">
                  <div class="relative inline-block group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Additional product image {{ $loop->iteration }}" class="w-full h-32 object-cover rounded-lg shadow cursor-pointer hover:shadow-md transition-shadow mb-2" onclick="openImageModal('{{ asset('storage/' . $image->image_path) }}', 'Additional Image {{ $loop->iteration }}')">
                    <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                      {{ $loop->iteration }}
                    </div>
                  </div>
                  <span class="text-xs text-gray-500">Image {{ $loop->iteration }}</span>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="imageModalLabel" role="dialog" aria-modal="true">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeImageModal()"></div>
    
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900" id="imageModalLabel">Image Preview</h3>
          <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeImageModal()">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <div class="text-center">
          <img id="modalImage" src="" alt="" class="max-w-full max-h-96 rounded-lg shadow-lg mx-auto">
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <a id="downloadBtn" href="" download class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
          <span class="material-symbols-outlined mr-2 text-sm">download</span>
          Download
        </a>
        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeImageModal()">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImage').alt = title;
    document.getElementById('imageModalLabel').textContent = title;
    document.getElementById('downloadBtn').href = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("vendor.products.destroy", $product) }}';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
