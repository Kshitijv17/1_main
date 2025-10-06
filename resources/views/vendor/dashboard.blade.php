@extends('vendor.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6 lg:mb-8">
    <h3 class="text-xl lg:text-3xl font-bold font-serif text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
    <p class="text-sm lg:text-base text-gray-600">Here's what's happening with your {{ auth()->user()->shop->name ?? 'shop' }} today.</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
    <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between mb-3 lg:mb-4">
            <div class="flex-1">
                <p class="text-xs lg:text-sm font-medium text-gray-600">Total Revenue</p>
            </div>
            <span class="material-symbols-outlined text-yellow-500 text-xl lg:text-2xl">local_florist</span>
        </div>
        <p class="text-xl lg:text-3xl font-bold text-gray-900">${{ number_format($stats['total_revenue'] ?? 45231.89, 2) }}</p>
        <p class="text-xs lg:text-sm text-green-600 mt-1">+20.1% from last month</p>
    </div>
    
    <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between mb-3 lg:mb-4">
            <div class="flex-1">
                <p class="text-xs lg:text-sm font-medium text-gray-600">Subscriptions</p>
            </div>
            <span class="material-symbols-outlined text-green-500 text-xl lg:text-2xl">eco</span>
        </div>
        <p class="text-xl lg:text-3xl font-bold text-gray-900">+{{ $stats['total_orders'] ?? 2350 }}</p>
        <p class="text-xs lg:text-sm text-green-600 mt-1">+180.1% from last month</p>
    </div>
    
    <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between mb-3 lg:mb-4">
            <div class="flex-1">
                <p class="text-xs lg:text-sm font-medium text-gray-600">Sales</p>
            </div>
            <span class="material-symbols-outlined text-amber-700 text-xl lg:text-2xl">potted_plant</span>
        </div>
        <p class="text-xl lg:text-3xl font-bold text-gray-900">+{{ $stats['total_products'] ?? 12234 }}</p>
        <p class="text-xs lg:text-sm text-green-600 mt-1">+19% from last month</p>
    </div>
    
    <div class="bg-white p-4 lg:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between mb-3 lg:mb-4">
            <div class="flex-1">
                <p class="text-xs lg:text-sm font-medium text-gray-600">Active Now</p>
            </div>
            <span class="material-symbols-outlined text-lime-600 text-xl lg:text-2xl">self_improvement</span>
        </div>
        <p class="text-xl lg:text-3xl font-bold text-gray-900">+{{ $stats['active_products'] ?? 573 }}</p>
        <p class="text-xs lg:text-sm text-gray-600 mt-1">Online</p>
    </div>
</div>
<!-- Recent Orders Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
    <h4 class="text-lg lg:text-xl font-semibold text-gray-900 mb-4">Recent Orders</h4>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2 lg:py-3 px-2 lg:px-4 font-semibold text-gray-700 text-xs lg:text-sm">User</th>
                    <th class="py-2 lg:py-3 px-2 lg:px-4 font-semibold text-gray-700 text-xs lg:text-sm">Status</th>
                    <th class="py-2 lg:py-3 px-2 lg:px-4 font-semibold text-gray-700 text-xs lg:text-sm hidden sm:table-cell">Date</th>
                    <th class="py-2 lg:py-3 px-2 lg:px-4 font-semibold text-gray-700 text-xs lg:text-sm text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    @foreach($recentOrders as $order)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-2 lg:py-3 px-2 lg:px-4">
                                <div class="flex items-center">
                                    <span class="material-symbols-outlined text-green-600 mr-2 text-sm lg:text-base hidden sm:inline">spa</span>
                                    <img alt="User avatar" class="w-6 h-6 lg:w-8 lg:h-8 rounded-full mr-2 lg:mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($order->user_name ?? 'User') }}&background=68d391&color=fff">
                                    <div>
                                        <p class="font-medium text-gray-900 text-xs lg:text-sm">{{ $order->user_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 hidden lg:block">{{ $order->user_email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2 lg:py-3 px-2 lg:px-4">
                                <span class="px-1 lg:px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($order->status === 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-2 lg:py-3 px-2 lg:px-4 text-gray-600 text-xs lg:text-sm hidden sm:table-cell">{{ $order->created_at->format('M d') }}</td>
                            <td class="py-2 lg:py-3 px-2 lg:px-4 text-right font-medium text-gray-900 text-xs lg:text-sm">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="py-6 lg:py-8 px-4 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-gray-400 text-3xl lg:text-4xl mb-2 lg:mb-3">receipt_long</span>
                                <h3 class="text-base lg:text-lg font-medium text-gray-900 mb-1">No Orders Yet</h3>
                                <p class="text-xs lg:text-sm text-gray-500">Orders from customers will appear here once you start receiving them.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
