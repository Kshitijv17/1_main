<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated with the appropriate guard for the role
        switch ($role) {
            case 'admin':
                if (!auth('admin')->check()) {
                    return redirect()->route('admin.login')->with('error', 'Please login as admin first.');
                }
                $user = auth('admin')->user();
                if (!$user->isAdmin()) {
                    return redirect()->route('admin.login')->with('error', 'Access denied. Admin privileges required.');
                }
                break;

            case 'vendor':
                if (!auth('vendor')->check()) {
                    return redirect()->route('vendor.login')->with('error', 'Please login as vendor first.');
                }
                $user = auth('vendor')->user();
                if (!$user->isVendor()) {
                    return redirect()->route('vendor.login')->with('error', 'Access denied. Vendor privileges required.');
                }
                break;

            case 'user':
                if (!auth('web')->check()) {
                    return redirect()->route('user.login')->with('error', 'Please login first.');
                }
                $user = auth('web')->user();
                if (!$user->isUser() && !$user->isGuest()) {
                    return redirect()->route('user.login')->with('error', 'Access denied. Please login as a customer.');
                }
                break;

            case 'guest':
                if (!auth('web')->check()) {
                    return redirect()->route('user.login')->with('error', 'Please login first.');
                }
                $user = auth('web')->user();
                if (!$user->isGuest()) {
                    return redirect()->route('user.home')->with('error', 'Access denied. Guest access only.');
                }
                break;

            default:
                return redirect()->route('user.home')->with('error', 'Access denied. Invalid role.');
        }

        return $next($request);
    }
}
