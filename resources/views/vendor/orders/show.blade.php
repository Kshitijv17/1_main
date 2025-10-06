@extends('vendor.layout')

@section('page-title', 'Order Details')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-xl">
                <span class="material-symbols-outlined text-2xl text-green-600">receipt_long</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-display">Order {{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">Complete order details and management</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('vendor.orders.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <span class="material-symbols-outlined mr-2 text-lg">arrow_back</span>
                Back to Orders
            </a>
        </div>
    </div>
</div>

<!-- Order Status Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Order Date</p>
                <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-gray-500">{{ $order->created_at->format('g:i A') }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <span class="material-symbols-outlined text-blue-600">calendar_today</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Amount</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($order->total_amount, 2) }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <span class="material-symbols-outlined text-green-600">payments</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Items Count</p>
                <p class="text-lg font-bold text-gray-900">{{ $order->items->count() }} items</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <span class="material-symbols-outlined text-purple-600">inventory</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Status</p>
                <div class="flex flex-col space-y-2 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        @if($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                        @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        Payment: {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Order Items -->
    <div class="xl:col-span-2 space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">shopping_bag</span>
                    <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Product</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">SKU</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Quantity</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Unit Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <span class="material-symbols-outlined text-gray-400">image</span>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $item->product_name }}</div>
                                        @if($item->product_options)
                                            <div class="text-sm text-gray-500">
                                                @foreach($item->product_options as $key => $value)
                                                    {{ ucfirst($key) }}: {{ $value }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-mono bg-gray-100 text-gray-800">
                                    {{ $item->product_sku ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-medium">
                                ${{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-bold">
                                ${{ number_format($item->total_price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-900">Subtotal:</td>
                            <td class="px-6 py-4 font-bold text-gray-900">${{ number_format($order->subtotal ?? $order->total_amount, 2) }}</td>
                        </tr>
                        @if(isset($order->tax_amount) && $order->tax_amount > 0)
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-gray-700">Tax:</td>
                            <td class="px-6 py-3 text-gray-900">${{ number_format($order->tax_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if(isset($order->shipping_amount) && $order->shipping_amount > 0)
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-gray-700">Shipping:</td>
                            <td class="px-6 py-3 text-gray-900">${{ number_format($order->shipping_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if(isset($order->discount_amount) && $order->discount_amount > 0)
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-green-700">Discount:</td>
                            <td class="px-6 py-3 text-green-700">-${{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="bg-gray-800 text-white">
                            <td colspan="4" class="px-6 py-4 text-right font-bold">Total:</td>
                            <td class="px-6 py-4 font-bold text-lg">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">history</span>
                    <h3 class="text-lg font-semibold text-gray-900">Order Timeline</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Order Placed -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-green-600 text-sm">add</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-500">
                                <h4 class="font-semibold text-gray-900">Order Placed</h4>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Processing -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-blue-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'text-blue-600' : 'text-gray-400' }} text-sm">settings</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'border-blue-500' : 'border-gray-300' }}">
                                <h4 class="font-semibold text-gray-900">Processing</h4>
                                <p class="text-sm text-gray-600">
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        Order is being processed
                                    @else
                                        Waiting for processing
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipped -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-purple-600' : 'text-gray-400' }} text-sm">local_shipping</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 {{ in_array($order->status, ['shipped', 'delivered']) ? 'border-purple-500' : 'border-gray-300' }}">
                                <h4 class="font-semibold text-gray-900">Shipped</h4>
                                <p class="text-sm text-gray-600">
                                    @if($order->shipped_at)
                                        {{ $order->shipped_at->format('M d, Y \a\t g:i A') }}
                                        @if($order->tracking_number)
                                            <br>Tracking: {{ $order->tracking_number }}
                                        @endif
                                    @elseif($order->status === 'shipped')
                                        Recently shipped
                                    @else
                                        Waiting for shipment
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 {{ $order->status === 'delivered' ? 'bg-green-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined {{ $order->status === 'delivered' ? 'text-green-600' : 'text-gray-400' }} text-sm">check</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 {{ $order->status === 'delivered' ? 'border-green-500' : 'border-gray-300' }}">
                                <h4 class="font-semibold text-gray-900">Delivered</h4>
                                <p class="text-sm text-gray-600">
                                    @if($order->delivered_at)
                                        {{ $order->delivered_at->format('M d, Y \a\t g:i A') }}
                                    @elseif($order->status === 'delivered')
                                        Recently delivered
                                    @else
                                        Waiting for delivery
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($order->status === 'cancelled')
                    <!-- Cancelled -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-red-600 text-sm">cancel</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-red-500">
                                <h4 class="font-semibold text-gray-900">Cancelled</h4>
                                <p class="text-sm text-gray-600">Order was cancelled</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status === 'refunded')
                    <!-- Refunded -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-yellow-600 text-sm">undo</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-yellow-500">
                                <h4 class="font-semibold text-gray-900">Refunded</h4>
                                <p class="text-sm text-gray-600">Order was refunded</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="xl:col-span-1 space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">person</span>
                    <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $order->user->name ?? 'Guest Customer' }}</h4>
                        <p class="text-sm text-gray-500">{{ $order->user->email ?? 'No email provided' }}</p>
                    </div>
                </div>
                @if($order->user)
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-900">{{ $order->user->orders()->count() }}</p>
                        <p class="text-sm text-gray-500">Total Orders</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-900">${{ number_format($order->user->orders()->sum('total_amount'), 2) }}</p>
                        <p class="text-sm text-gray-500">Total Spent</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
        @if($order->shipping_address)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">local_shipping</span>
                    <h3 class="text-lg font-semibold text-gray-900">Shipping Address</h3>
                </div>
            </div>
            <div class="p-6">
                <address class="not-italic text-gray-700">
                    @if(isset($order->shipping_address['name']))
                        <div class="font-semibold text-gray-900">{{ $order->shipping_address['name'] }}</div>
                    @endif
                    @if(isset($order->shipping_address['address_line_1']))
                        <div>{{ $order->shipping_address['address_line_1'] }}</div>
                    @endif
                    @if(isset($order->shipping_address['address_line_2']) && $order->shipping_address['address_line_2'])
                        <div>{{ $order->shipping_address['address_line_2'] }}</div>
                    @endif
                    <div>
                        @if(isset($order->shipping_address['city']))
                            {{ $order->shipping_address['city'] }}{{ isset($order->shipping_address['state']) ? ', ' : '' }}
                        @endif
                        @if(isset($order->shipping_address['state']))
                            {{ $order->shipping_address['state'] }}
                        @endif
                        @if(isset($order->shipping_address['postal_code']))
                            {{ $order->shipping_address['postal_code'] }}
                        @endif
                    </div>
                    @if(isset($order->shipping_address['country']))
                        <div>{{ $order->shipping_address['country'] }}</div>
                    @endif
                </address>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">settings</span>
                    <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                </div>
            </div>
            <div class="p-6 space-y-3">
                <button onclick="window.print()" 
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <span class="material-symbols-outlined mr-2">print</span>
                    Print Order
                </button>
                
                @if($order->canBeCancelled())
                <button onclick="cancelOrder()" 
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                    <span class="material-symbols-outlined mr-2">cancel</span>
                    Cancel Order
                </button>
                @endif

                @if($order->canBeRefunded())
                <button onclick="showRefundModal({{ $order->id }}, {{ $order->total_amount }})" 
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                    <span class="material-symbols-outlined mr-2">undo</span>
                    Refund Order
                </button>
                @endif
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">sticky_note_2</span>
                    <h3 class="text-lg font-semibold text-gray-900">Order Notes</h3>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
async function cancelOrder() {
  if (!confirm('Are you sure you want to cancel this order?')) {
    return;
  }

  try {
    const response = await fetch(`/vendor/orders/{{ $order->id }}/cancel`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    });

    const result = await response.json();
    
    if (result.success) {
      showAlert('success', result.message);
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showAlert('error', result.message);
    }
  } catch (error) {
    showAlert('error', 'Failed to cancel order');
  }
}

function showAlert(type, message) {
  const alertContainer = document.createElement('div');
  alertContainer.className = 'fixed top-4 right-4 z-50';
  
  const alert = document.createElement('div');
  alert.className = `flex items-center p-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
    type === 'success' 
      ? 'bg-green-50 border-green-200 text-green-800' 
      : 'bg-red-50 border-red-200 text-red-800'
  }`;
  
  alert.innerHTML = `
    <span class="material-symbols-outlined mr-3 ${type === 'success' ? 'text-green-600' : 'text-red-600'}">
      ${type === 'success' ? 'check_circle' : 'error'}
    </span>
    <span class="font-medium">${message}</span>
    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 p-1 rounded-lg hover:bg-black hover:bg-opacity-10 transition-colors duration-200">
      <span class="material-symbols-outlined text-sm">close</span>
    </button>
  `;
  
  alertContainer.appendChild(alert);
  document.body.appendChild(alertContainer);
  
  setTimeout(() => {
    if (alertContainer.parentNode) {
      alertContainer.remove();
    }
  }, 5000);
}
</script>

@if(!isset($__env->getShared()['__csrf_token']))
<meta name="csrf-token" content="{{ csrf_token() }}">
@endif

@endsection
