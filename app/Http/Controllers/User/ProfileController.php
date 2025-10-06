<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get user statistics
        $stats = [
            'total_orders' => $user->orders()->count() ?? 0,
            'total_spent' => $user->orders()->where('status', 'delivered')->sum('total_amount') ?? 0,
            'wishlist_count' => 0, // Wishlist functionality to be implemented
        ];
        
        // Get recent orders
        $recentOrders = $user->orders()
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.profile', compact('user', 'stats', 'recentOrders'));
    }
    
    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'landmark' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);
        
        // Don't allow email updates for security reasons
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'city' => $request->city,
            'landmark' => $request->landmark,
            'locality' => $request->locality,
            'address' => $request->address,
        ]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!'
            ]);
        }
        
        return redirect()->route('user.profile')
            ->with('success', 'Address updated successfully!');
    }
    
    /**
     * Update the user password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('user.profile')
            ->with('success', 'Password updated successfully!');
    }
}
