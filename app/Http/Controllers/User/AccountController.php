<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
                           ->latest()
                           ->take(5)
                           ->get();
        
        return view('user.pages.my-account', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                      ->latest()
                      ->paginate(10);
        
        return view('user.pages.my-orders', compact('orders'));
    }
}
