<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Show login form
    public function loginForm()
    {
        // Only redirect if already logged in with vendor guard
        if (auth('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }

        // Always show vendor login form
        return view('vendor.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->isVendor() && Hash::check($request->password, $user->password)) {
            Auth::guard('vendor')->login($user);
            $request->session()->regenerate();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! Welcome to your vendor dashboard!',
                    'redirect' => route('vendor.dashboard')
                ]);
            }
            
            return redirect()->route('vendor.dashboard')->with('success', 'Welcome to your vendor dashboard!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials or not a vendor account.',
                'errors' => ['email' => ['Invalid credentials or not a vendor account.']]
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not a vendor account.',
        ])->withInput();
    }

    // Show registration form
    public function registerForm()
    {
        // Only redirect if already logged in with vendor guard
        if (auth('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }

        // Always show vendor register form
        return view('vendor.register');
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
                'role' => UserRole::VENDOR->value,
                'is_guest' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = User::find($userId);
            Auth::guard('vendor')->login($user);
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vendor account created successfully! Welcome to your shop!',
                    'redirect' => route('vendor.dashboard')
                ]);
            }

            return redirect()->route('vendor.dashboard')->with('success', 'Vendor account created successfully! Welcome to your shop!');
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
    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }
}
