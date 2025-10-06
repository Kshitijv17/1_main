<?php

namespace App\Http\Controllers\User;

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
        // Redirect if already logged in with web guard
        if (auth('web')->check()) {
            return redirect()->route('user.home');
        }

        // Redirect to homepage with modal trigger
        return redirect()->route('user.home')->with('show_login_modal', true);
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Handle AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful! Redirecting...',
                    'redirect' => route('user.home')
                ]);
            }
            
            return redirect()->intended(route('user.home'));
        }

        // Handle AJAX error response
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.',
                'errors' => [
                    'email' => ['The provided credentials do not match our records.']
                ]
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not a user account.',
        ])->withInput();
    }

    // Show registration form
    public function registerForm()
    {
        // Redirect if already logged in with web guard
        if (auth('web')->check()) {
            return redirect()->route('user.home');
        }

        // Redirect to homepage with modal trigger
        return redirect()->route('user.home')->with('show_register_modal', true);
    }

    // Handle registration
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::USER,
                'is_guest' => false,
            ]);

            Auth::guard('web')->login($user);
            $request->session()->regenerate();

            // Handle AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account created successfully! Welcome to our store!',
                    'redirect' => route('user.home')
                ]);
            }

            return redirect()->route('user.home')->with('success', 'Account created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle AJAX validation errors
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fix the errors below.',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create account. Please try again.',
                    'errors' => ['error' => [$e->getMessage()]]
                ], 500);
            }
            
            return back()->withInput()->withErrors(['error' => 'Failed to create account: ' . $e->getMessage()]);
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('user.home');
    }
}
