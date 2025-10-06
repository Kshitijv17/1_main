<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    // Show login form
    public function loginForm()
    {
        // Only redirect if already logged in with admin guard
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Always show admin login form
        return view('auth.admin-login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->isAdmin() && Hash::check($request->password, $user->password)) {
            Auth::guard('admin')->login($user);
            $request->session()->regenerate();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! Welcome to admin dashboard!',
                    'redirect' => route('admin.dashboard')
                ]);
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to admin dashboard!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials or not an admin account.',
                'errors' => ['email' => ['Invalid credentials or not an admin account.']]
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not an admin account.',
        ])->withInput();
    }

    // Show registration form
    public function registerForm()
    {
        // Only redirect if already logged in with admin guard
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Always show admin register form
        return view('auth.admin-register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::ADMIN->value,
                'is_guest' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = User::find($userId);
            Auth::guard('admin')->login($user);
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin account created successfully! Welcome to the admin panel!',
                    'redirect' => route('admin.dashboard')
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Admin account created successfully! Welcome to the admin panel!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create account: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->withErrors(['error' => 'Failed to create account: ' . $e->getMessage()]);
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}
