@extends('vendor.layout')

@section('page-title', 'Edit Order')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 rounded-xl">
                <span class="material-symbols-outlined text-2xl text-yellow-600">edit</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-display">Edit Order {{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">Update order details and status</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('vendor.orders.show', $order) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <span class="material-symbols-outlined mr-2 text-lg">visibility</span>
                View Order
            </a>
            <a href="{{ route('vendor.orders.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <span class="material-symbols-outlined mr-2 text-lg">arrow_back</span>
                Back to Orders
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600">edit</span>
                    <h3 class="text-lg font-semibold text-gray-900">Edit Order Details</h3>
                </div>
            </div>

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <span class="material-symbols-outlined text-red-600 mt-0.5">error</span>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('vendor.orders.update', $order) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">
                            Order Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 @error('status') border-red-500 @enderror" 
                                required>
                            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $order->status) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Current:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($order->status === 'delivered') bg-green-100 text-green-800
                                @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-semibold text-gray-900 mb-2">
                            Payment Status <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_status" id="payment_status" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 @error('payment_status') border-red-500 @enderror" 
                                required>
                            @foreach(\App\Models\Order::getPaymentStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ old('payment_status', $order->payment_status) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Current:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @error('payment_status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            <!-- Payment and Tracking -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="payment_method" class="form-label">Payment Method</label>
                  <input type="text" name="payment_method" id="payment_method" 
                         class="form-control @error('payment_method') is-invalid @enderror"
                         value="{{ old('payment_method', $order->payment_method) }}" 
                         placeholder="e.g., Credit Card, PayPal, Bank Transfer">
                  @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="tracking_number" class="form-label">Tracking Number</label>
                  <input type="text" name="tracking_number" id="tracking_number" 
                         class="form-control @error('tracking_number') is-invalid @enderror"
                         value="{{ old('tracking_number', $order->tracking_number) }}" 
                         placeholder="Enter tracking number">
                  @error('tracking_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Order Notes -->
            <div class="mb-4">
              <label for="notes" class="form-label">Order Notes</label>
              <textarea name="notes" id="notes" rows="4" 
                        class="form-control @error('notes') is-invalid @enderror"
                        placeholder="Add any notes about this order...">{{ old('notes', $order->notes) }}</textarea>
              @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Shipping Address -->
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-truck me-2"></i>Shipping Address</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="shipping_name" class="form-label">Full Name</label>
                      <input type="text" name="shipping_address[name]" id="shipping_name" 
                             class="form-control"
                             value="{{ old('shipping_address.name', $order->shipping_address['name'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="shipping_phone" class="form-label">Phone Number</label>
                      <input type="text" name="shipping_address[phone]" id="shipping_phone" 
                             class="form-control"
                             value="{{ old('shipping_address.phone', $order->shipping_address['phone'] ?? '') }}">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="shipping_address_line_1" class="form-label">Address Line 1</label>
                  <input type="text" name="shipping_address[address_line_1]" id="shipping_address_line_1" 
                         class="form-control"
                         value="{{ old('shipping_address.address_line_1', $order->shipping_address['address_line_1'] ?? '') }}">
                </div>
                <div class="mb-3">
                  <label for="shipping_address_line_2" class="form-label">Address Line 2</label>
                  <input type="text" name="shipping_address[address_line_2]" id="shipping_address_line_2" 
                         class="form-control"
                         value="{{ old('shipping_address.address_line_2', $order->shipping_address['address_line_2'] ?? '') }}">
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="shipping_city" class="form-label">City</label>
                      <input type="text" name="shipping_address[city]" id="shipping_city" 
                             class="form-control"
                             value="{{ old('shipping_address.city', $order->shipping_address['city'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="shipping_state" class="form-label">State/Province</label>
                      <input type="text" name="shipping_address[state]" id="shipping_state" 
                             class="form-control"
                             value="{{ old('shipping_address.state', $order->shipping_address['state'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="shipping_postal_code" class="form-label">Postal Code</label>
                      <input type="text" name="shipping_address[postal_code]" id="shipping_postal_code" 
                             class="form-control"
                             value="{{ old('shipping_address.postal_code', $order->shipping_address['postal_code'] ?? '') }}">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="shipping_country" class="form-label">Country</label>
                  <input type="text" name="shipping_address[country]" id="shipping_country" 
                         class="form-control"
                         value="{{ old('shipping_address.country', $order->shipping_address['country'] ?? '') }}">
                </div>
              </div>
            </div>

            <!-- Billing Address -->
            <div class="card mb-4">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Billing Address</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="same_as_shipping" onchange="copyShippingToBilling()">
                    <label class="form-check-label" for="same_as_shipping">
                      Same as shipping
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="billing_name" class="form-label">Full Name</label>
                      <input type="text" name="billing_address[name]" id="billing_name" 
                             class="form-control"
                             value="{{ old('billing_address.name', $order->billing_address['name'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="billing_phone" class="form-label">Phone Number</label>
                      <input type="text" name="billing_address[phone]" id="billing_phone" 
                             class="form-control"
                             value="{{ old('billing_address.phone', $order->billing_address['phone'] ?? '') }}">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="billing_address_line_1" class="form-label">Address Line 1</label>
                  <input type="text" name="billing_address[address_line_1]" id="billing_address_line_1" 
                         class="form-control"
                         value="{{ old('billing_address.address_line_1', $order->billing_address['address_line_1'] ?? '') }}">
                </div>
                <div class="mb-3">
                  <label for="billing_address_line_2" class="form-label">Address Line 2</label>
                  <input type="text" name="billing_address[address_line_2]" id="billing_address_line_2" 
                         class="form-control"
                         value="{{ old('billing_address.address_line_2', $order->billing_address['address_line_2'] ?? '') }}">
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="billing_city" class="form-label">City</label>
                      <input type="text" name="billing_address[city]" id="billing_city" 
                             class="form-control"
                             value="{{ old('billing_address.city', $order->billing_address['city'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="billing_state" class="form-label">State/Province</label>
                      <input type="text" name="billing_address[state]" id="billing_state" 
                             class="form-control"
                             value="{{ old('billing_address.state', $order->billing_address['state'] ?? '') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="billing_postal_code" class="form-label">Postal Code</label>
                      <input type="text" name="billing_address[postal_code]" id="billing_postal_code" 
                             class="form-control"
                             value="{{ old('billing_address.postal_code', $order->billing_address['postal_code'] ?? '') }}">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="billing_country" class="form-label">Country</label>
                  <input type="text" name="billing_address[country]" id="billing_country" 
                         class="form-control"
                         value="{{ old('billing_address.country', $order->billing_address['country'] ?? '') }}">
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-between">
              <a href="{{ route('vendor.orders.show', $order) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Update Order
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div class="col-lg-4">
      <!-- Order Summary -->
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h6>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <tr>
              <td><strong>Order Number:</strong></td>
              <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
              <td><strong>user:</strong></td>
              <td>{{ $order->user->name ?? 'Guest' }}</td>
            </tr>
            <tr>
              <td><strong>Email:</strong></td>
              <td>{{ $order->user->email ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td><strong>Order Date:</strong></td>
              <td>{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            <tr>
              <td><strong>Items:</strong></td>
              <td>{{ $order->items->count() }} items</td>
            </tr>
            <tr>
              <td><strong>Total:</strong></td>
              <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Order Items -->
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Items</h6>
        </div>
        <div class="card-body">
          @foreach($order->items as $item)
            <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
              @if($item->product && $item->product->image)
                <img src="{{ asset('storage/' . $item->product->image) }}" 
                     alt="{{ $item->product_name }}" 
                     class="rounded me-3" 
                     style="width: 40px; height: 40px; object-fit: cover;">
              @else
                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                     style="width: 40px; height: 40px;">
                  <i class="fas fa-image text-muted"></i>
                </div>
              @endif
              <div class="flex-grow-1">
                <div class="fw-bold">{{ $item->product_name }}</div>
                <small class="text-muted">
                  Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                </small>
              </div>
              <div class="text-end">
                <strong>${{ number_format($item->total_price, 2) }}</strong>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-outline-success" onclick="setStatusPaid()">
              <i class="fas fa-check me-2"></i>Mark as Paid
            </button>
            <button type="button" class="btn btn-outline-info" onclick="setStatusShipped()">
              <i class="fas fa-truck me-2"></i>Mark as Shipped
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="setStatusDelivered()">
              <i class="fas fa-check-circle me-2"></i>Mark as Delivered
            </button>
            @if($order->canBeCancelled())
              <button type="button" class="btn btn-outline-danger" onclick="setStatusCancelled()">
                <i class="fas fa-ban me-2"></i>Cancel Order
              </button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function copyShippingToBilling() {
  const checkbox = document.getElementById('same_as_shipping');
  
  if (checkbox.checked) {
    // Copy shipping address to billing address
    document.getElementById('billing_name').value = document.getElementById('shipping_name').value;
    document.getElementById('billing_phone').value = document.getElementById('shipping_phone').value;
    document.getElementById('billing_address_line_1').value = document.getElementById('shipping_address_line_1').value;
    document.getElementById('billing_address_line_2').value = document.getElementById('shipping_address_line_2').value;
    document.getElementById('billing_city').value = document.getElementById('shipping_city').value;
    document.getElementById('billing_state').value = document.getElementById('shipping_state').value;
    document.getElementById('billing_postal_code').value = document.getElementById('shipping_postal_code').value;
    document.getElementById('billing_country').value = document.getElementById('shipping_country').value;
  }
}

function setStatusPaid() {
  document.getElementById('payment_status').value = 'paid';
}

function setStatusShipped() {
  document.getElementById('status').value = 'shipped';
  
  // Prompt for tracking number if not set
  const trackingInput = document.getElementById('tracking_number');
  if (!trackingInput.value) {
    const trackingNumber = prompt('Enter tracking number (optional):');
    if (trackingNumber) {
      trackingInput.value = trackingNumber;
    }
  }
}

function setStatusDelivered() {
  document.getElementById('status').value = 'delivered';
}

function setStatusCancelled() {
  if (confirm('Are you sure you want to cancel this order?')) {
    document.getElementById('status').value = 'cancelled';
  }
}

// Auto-update payment status when order status changes
document.getElementById('status').addEventListener('change', function() {
  const status = this.value;
  const paymentStatus = document.getElementById('payment_status');
  
  if (status === 'delivered' && paymentStatus.value === 'pending') {
    paymentStatus.value = 'paid';
  }
});
</script>

@endsection
