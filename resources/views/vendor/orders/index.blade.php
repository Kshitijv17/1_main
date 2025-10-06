@extends('vendor.layout')

@section('content')
<!-- Header Section -->
    <div class="mb-6 lg:mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-3 lg:space-x-4">
                <div class="p-2 lg:p-3 bg-green-100 dark:bg-green-900 rounded-xl">
                    <span class="material-symbols-outlined text-xl lg:text-2xl text-green-600 dark:text-green-400">receipt_long</span>
                </div>
                <div>
                    <h1 class="text-xl lg:text-3xl font-bold text-gray-900 font-display">Orders Management</h1>
                    <p class="text-sm lg:text-base text-gray-700 mt-1">Track and manage all your user orders</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 lg:space-x-3">
                <a href="{{ route('vendor.orders.export', request()->query()) }}" 
                   class="inline-flex items-center px-3 lg:px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-800 transition-colors duration-200 text-sm lg:text-base">
                    <span class="material-symbols-outlined mr-1 lg:mr-2 text-sm lg:text-lg">download</span>
                    <span class="hidden sm:inline">Export CSV</span>
                    <span class="sm:hidden">Export</span>
                </a>
                <button onclick="refreshOrders()" 
                        class="inline-flex items-center px-3 lg:px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 text-sm lg:text-base">
                    <span class="material-symbols-outlined mr-1 lg:mr-2 text-sm lg:text-lg">refresh</span>
                    <span class="hidden sm:inline">Refresh</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl lg:rounded-2xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs lg:text-sm font-medium">Total Orders</p>
                    <p class="text-xl lg:text-3xl font-bold mt-1">{{ number_format($stats['total_orders']) }}</p>
                </div>
                <div class="p-2 lg:p-3 bg-white bg-opacity-20 rounded-lg lg:rounded-xl">
                    <span class="material-symbols-outlined text-lg lg:text-2xl">shopping_cart</span>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl lg:rounded-2xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Pending Orders</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($stats['pending_orders']) }}</p>
                </div>
                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                    <span class="material-symbols-outlined text-2xl">schedule</span>
                </div>
            </div>
        </div>

        <!-- Processing Orders -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Processing</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($stats['processing_orders']) }}</p>
                </div>
                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                    <span class="material-symbols-outlined text-2xl">settings</span>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold mt-1">${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                    <span class="material-symbols-outlined text-2xl">payments</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">filter_list</span>
                    <h3 class="text-lg font-semibold text-gray-900">Filters & Search</h3>
                </div>
                <button onclick="clearFilters()" 
                        class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <span class="material-symbols-outlined mr-1 text-sm">clear</span>
                    Clear Filters
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <form method="GET" action="{{ route('vendor.orders.index') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="material-symbols-outlined mr-1 text-sm align-middle">search</span>
                            Search Orders
                        </label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400"
                               value="{{ request('search') }}" 
                               placeholder="Order #, user name, email...">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="material-symbols-outlined mr-1 text-sm align-middle">assignment</span>
                            Status
                        </label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700">
                            <option value="">All Statuses</option>
                            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="material-symbols-outlined mr-1 text-sm align-middle">payment</span>
                            Payment
                        </label>
                        <select name="payment_status" 
                                id="payment_status" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700">
                            <option value="">All Payments</option>
                            @foreach(\App\Models\Order::getPaymentStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ request('payment_status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="material-symbols-outlined mr-1 text-sm align-middle">calendar_today</span>
                            From Date
                        </label>
                        <input type="date" 
                               name="date_from" 
                               id="date_from" 
                               class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700"
                               value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="material-symbols-outlined mr-1 text-sm align-middle">event</span>
                            To Date
                        </label>
                        <input type="date" 
                               name="date_to" 
                               id="date_to" 
                               class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700"
                               value="{{ request('date_to') }}">
                    </div>
                </div>

                <!-- Search Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined mr-2">search</span>
                        Search Orders
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">receipt_long</span>
                    <h3 class="text-lg font-semibold text-gray-900">
                        Orders
                        <span class="ml-2 px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-sm font-medium">
                            {{ $orders->total() }}
                        </span>
                    </h3>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div id="order-{{ $order->id }}" class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-200">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
                                <!-- Order Info -->
                                <div class="lg:col-span-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-green-600 dark:text-green-400">receipt</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                            @if($order->tracking_number)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                                    <span class="material-symbols-outlined mr-1 text-xs">local_shipping</span>
                                                    {{ $order->tracking_number }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- user Info -->
                                <div class="lg:col-span-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold text-sm">
                                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-700">{{ $order->user->name ?? 'Guest' }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($order->user->email ?? 'No email', 20) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badges -->
                                <div class="lg:col-span-2">
                                    <div class="space-y-2">
                                        <div class="relative">
                                            <button onclick="toggleStatusDropdown({{ $order->id }})" 
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-colors duration-200
                                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                {{ $order->status_display }}
                                                <span class="material-symbols-outlined ml-1 text-xs">expand_more</span>
                                            </button>
                                            <div id="status-dropdown-{{ $order->id }}" class="hidden absolute top-full left-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                                @foreach(\App\Models\Order::getStatuses() as $statusKey => $statusLabel)
                                                    @if($statusKey !== $order->status)
                                                        <button onclick="updateOrderStatus({{ $order->id }}, '{{ $statusKey }}')" 
                                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 first:rounded-t-lg last:rounded-b-lg">
                                                            {{ $statusLabel }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <button onclick="togglePaymentDropdown({{ $order->id }})" 
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-colors duration-200
                                                    @if($order->payment_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @elseif($order->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                {{ $order->payment_status_display }}
                                                <span class="material-symbols-outlined ml-1 text-xs">expand_more</span>
                                            </button>
                                            <div id="payment-dropdown-{{ $order->id }}" class="hidden absolute top-full left-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                                @foreach(\App\Models\Order::getPaymentStatuses() as $paymentKey => $paymentLabel)
                                                    @if($paymentKey !== $order->payment_status)
                                                        <button onclick="updatePaymentStatus({{ $order->id }}, '{{ $paymentKey }}')" 
                                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 first:rounded-t-lg last:rounded-b-lg">
                                                            {{ $paymentLabel }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Details -->
                                <div class="lg:col-span-2">
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Items: 
                                            <span class="font-medium text-gray-700">{{ $order->items->count() }}</span>
                                        </p>
                                        <p class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($order->total_amount, 2) }}</p>
                                        @if($order->currency !== 'USD')
                                            <p class="text-xs text-gray-400">{{ $order->currency }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="lg:col-span-1">
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-gray-700">{{ $order->created_at->format('M d') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('Y') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="lg:col-span-2">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('vendor.orders.show', $order) }}" 
                                           class="p-2 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200" 
                                           title="View Order">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </a>
                                        <a href="{{ route('vendor.orders.edit', $order) }}" 
                                           class="p-2 bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400 rounded-lg hover:bg-amber-200 dark:hover:bg-amber-800 transition-colors duration-200" 
                                           title="Edit Order">
                                            <span class="material-symbols-outlined text-sm">edit</span>
                                        </a>
                                        <div class="relative">
                                            <button onclick="toggleActionsDropdown({{ $order->id }})" 
                                                    class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                                <span class="material-symbols-outlined text-sm">more_vert</span>
                                            </button>
                                            <div id="actions-dropdown-{{ $order->id }}" class="hidden absolute top-full right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                                @if($order->canBeCancelled())
                                                    <button onclick="cancelOrder({{ $order->id }})" 
                                                            class="w-full text-left px-4 py-2 text-sm text-amber-600 dark:text-amber-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg flex items-center">
                                                        <span class="material-symbols-outlined mr-2 text-sm">cancel</span>
                                                        Cancel Order
                                                    </button>
                                                @endif
                                                @if($order->canBeRefunded())
                                                    <button onclick="showRefundModal({{ $order->id }}, {{ $order->total_amount }})" 
                                                            class="w-full text-left px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                                        <span class="material-symbols-outlined mr-2 text-sm">undo</span>
                                                        Refund Order
                                                    </button>
                                                @endif
                                                <hr class="my-1 border-gray-300">
                                                <button onclick="deleteOrder({{ $order->id }}, '{{ $order->order_number }}')" 
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-lg flex items-center">
                                                    <span class="material-symbols-outlined mr-2 text-sm">delete</span>
                                                    Delete Order
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-gray-400">receipt_long</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Orders Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">No orders match your current filters.</p>
                    @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                        <button onclick="clearFilters()" 
                                class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-800 transition-colors duration-200">
                            <span class="material-symbols-outlined mr-2 text-sm">clear</span>
                            Clear Filters
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden" onclick="closeRefundModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-yellow-600">undo</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Refund Order</h3>
                </div>
                <button onclick="closeRefundModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <span class="material-symbols-outlined text-gray-500">close</span>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <form id="refundForm">
                @csrf
                <!-- Refund Amount -->
                <div class="mb-6">
                    <label for="refund_amount" class="block text-sm font-semibold text-gray-900 mb-2">
                        <span class="material-symbols-outlined mr-2 text-sm align-middle text-green-600">payments</span>
                        Refund Amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">$</span>
                        <input type="number" name="refund_amount" id="refund_amount" 
                               class="w-full pl-8 pr-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700"
                               step="0.01" min="0" required placeholder="0.00">
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Maximum refund amount: $<span id="max_refund_amount" class="font-medium text-gray-700">0.00</span></p>
                </div>
                
                <!-- Refund Reason -->
                <div class="mb-6">
                    <label for="refund_reason" class="block text-sm font-semibold text-gray-900 mb-2">
                        <span class="material-symbols-outlined mr-2 text-sm align-middle text-green-600">description</span>
                        Refund Reason (Optional)
                    </label>
                    <textarea name="refund_reason" id="refund_reason" rows="3"
                              class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-400"
                              placeholder="Enter reason for refund..."></textarea>
                </div>
            </form>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closeRefundModal()" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                Cancel
            </button>
            <button onclick="processRefund()" 
                    class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
                <span class="material-symbols-outlined mr-2 text-sm">undo</span>
                Process Refund
            </button>
        </div>
    </div>
</div>

<script>
let currentOrderId = null;

// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
  const filterInputs = document.querySelectorAll('#filterForm select, #filterForm input[type="date"]');
  filterInputs.forEach(input => {
    input.addEventListener('change', function() {
      document.getElementById('filterForm').submit();
    });
  });

  // Search with debounce
  let searchTimeout;
  document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      document.getElementById('filterForm').submit();
    }, 500);
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
      document.querySelectorAll('[id^="status-dropdown-"], [id^="payment-dropdown-"], [id^="actions-dropdown-"]').forEach(dropdown => {
        dropdown.classList.add('hidden');
      });
    }
  });

  // Close modal with escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeRefundModal();
    }
  });
});

function clearFilters() {
  window.location.href = '{{ route("vendor.orders.index") }}';
}

function refreshOrders() {
  window.location.reload();
}

function toggleStatusDropdown(orderId) {
  const dropdown = document.getElementById(`status-dropdown-${orderId}`);
  const isHidden = dropdown.classList.contains('hidden');
  
  // Close all dropdowns
  document.querySelectorAll('[id^="status-dropdown-"], [id^="payment-dropdown-"], [id^="actions-dropdown-"]').forEach(d => {
    d.classList.add('hidden');
  });
  
  // Toggle current dropdown
  if (isHidden) {
    dropdown.classList.remove('hidden');
  }
}

function togglePaymentDropdown(orderId) {
  const dropdown = document.getElementById(`payment-dropdown-${orderId}`);
  const isHidden = dropdown.classList.contains('hidden');
  
  // Close all dropdowns
  document.querySelectorAll('[id^="status-dropdown-"], [id^="payment-dropdown-"], [id^="actions-dropdown-"]').forEach(d => {
    d.classList.add('hidden');
  });
  
  // Toggle current dropdown
  if (isHidden) {
    dropdown.classList.remove('hidden');
  }
}

function toggleActionsDropdown(orderId) {
  const dropdown = document.getElementById(`actions-dropdown-${orderId}`);
  const isHidden = dropdown.classList.contains('hidden');
  
  // Close all dropdowns
  document.querySelectorAll('[id^="status-dropdown-"], [id^="payment-dropdown-"], [id^="actions-dropdown-"]').forEach(d => {
    d.classList.add('hidden');
  });
  
  // Toggle current dropdown
  if (isHidden) {
    dropdown.classList.remove('hidden');
  }
}

async function updateOrderStatus(orderId, status) {
  try {
    // Close dropdown
    document.getElementById(`status-dropdown-${orderId}`).classList.add('hidden');
    
    const response = await fetch(`/vendor/orders/${orderId}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ status: status })
    });

    const result = await response.json();
    
    if (result.success) {
      showAlert('success', result.message);
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showAlert('error', result.message);
    }
  } catch (error) {
    showAlert('error', 'Failed to update order status');
  }
}

async function updatePaymentStatus(orderId, paymentStatus) {
  try {
    // Close dropdown
    document.getElementById(`payment-dropdown-${orderId}`).classList.add('hidden');
    
    const response = await fetch(`/vendor/orders/${orderId}/payment-status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ payment_status: paymentStatus })
    });

    const result = await response.json();
    
    if (result.success) {
      showAlert('success', result.message);
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showAlert('error', result.message);
    }
  } catch (error) {
    showAlert('error', 'Failed to update payment status');
  }
}

async function cancelOrder(orderId) {
  // Close dropdown
  document.getElementById(`actions-dropdown-${orderId}`).classList.add('hidden');
  
  if (!confirm('Are you sure you want to cancel this order?')) {
    return;
  }

  try {
    const response = await fetch(`/vendor/orders/${orderId}/cancel`, {
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

function showRefundModal(orderId, maxAmount) {
  // Close dropdown
  document.getElementById(`actions-dropdown-${orderId}`).classList.add('hidden');
  
  currentOrderId = orderId;
  document.getElementById('refund_amount').max = maxAmount;
  document.getElementById('refund_amount').value = maxAmount;
  document.getElementById('max_refund_amount').textContent = maxAmount.toFixed(2);
  
  // Show custom modal
  document.getElementById('refundModal').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeRefundModal() {
  document.getElementById('refundModal').classList.add('hidden');
  document.body.style.overflow = 'auto';
  
  // Reset form
  document.getElementById('refundForm').reset();
  currentOrderId = null;
}

async function processRefund() {
  const form = document.getElementById('refundForm');
  const formData = new FormData(form);

  try {
    const response = await fetch(`/vendor/orders/${currentOrderId}/refund`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        refund_amount: formData.get('refund_amount'),
        refund_reason: formData.get('refund_reason')
      })
    });

    const result = await response.json();
    
    if (result.success) {
      showAlert('success', result.message);
      closeRefundModal();
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showAlert('error', result.message);
    }
  } catch (error) {
    showAlert('error', 'Failed to process refund');
  }
}

function deleteOrder(orderId, orderNumber) {
  // Close dropdown
  document.getElementById(`actions-dropdown-${orderId}`).classList.add('hidden');
  
  if (!confirm(`Are you sure you want to delete order ${orderNumber}?\n\nThis action cannot be undone.`)) {
    return;
  }

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/vendor/orders/${orderId}`;
  
  const csrfToken = document.createElement('input');
  csrfToken.type = 'hidden';
  csrfToken.name = '_token';
  csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
  
  const methodField = document.createElement('input');
  methodField.type = 'hidden';
  methodField.name = '_method';
  methodField.value = 'DELETE';
  
  form.appendChild(csrfToken);
  form.appendChild(methodField);
  document.body.appendChild(form);
  form.submit();
}

function showAlert(type, message) {
  const alertContainer = document.createElement('div');
  alertContainer.className = 'fixed top-4 right-4 z-50';
  
  const alert = document.createElement('div');
  alert.className = `flex items-center p-4 rounded-xl shadow-lg border transform transition-all duration-300 translate-x-full ${
    type === 'success' 
      ? 'bg-green-50 dark:bg-green-900 border-green-200 dark:border-green-800 text-green-800 dark:text-green-200' 
      : 'bg-red-50 dark:bg-red-900 border-red-200 dark:border-red-800 text-red-800 dark:text-red-200'
  }`;
  
  alert.innerHTML = `
    <span class="material-symbols-outlined mr-3 ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
      ${type === 'success' ? 'check_circle' : 'error'}
    </span>
    <span class="font-medium">${message}</span>
    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 p-1 rounded-lg hover:bg-black hover:bg-opacity-10 transition-colors duration-200">
      <span class="material-symbols-outlined text-sm">close</span>
    </button>
  `;
  
  alertContainer.appendChild(alert);
  document.body.appendChild(alertContainer);
  
  // Animate in
  setTimeout(() => {
    alert.classList.remove('translate-x-full');
  }, 100);
  
  // Auto remove after 5 seconds
  setTimeout(() => {
    alert.classList.add('translate-x-full');
    setTimeout(() => {
      if (alertContainer.parentNode) {
        alertContainer.remove();
      }
    }, 300);
  }, 5000);
}
</script>

@if(!isset($__env->getShared()['__csrf_token']))
<meta name="csrf-token" content="{{ csrf_token() }}">
@endif

@endsection
