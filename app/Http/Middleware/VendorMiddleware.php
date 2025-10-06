<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with vendor guard
        if (!auth('vendor')->check()) {
            return redirect()->route('vendor.login')->with('error', 'Please login as vendor first.');
        }

        // Check if user has vendor role
        if (!auth('vendor')->user()->isVendor()) {
            abort(403, 'Access denied. Vendor privileges required.');
        }

        return $next($request);
    }
}
