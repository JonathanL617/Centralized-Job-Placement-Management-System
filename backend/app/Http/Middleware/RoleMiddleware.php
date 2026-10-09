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
        // If they aren't logged in, or their role doesn't match the required role for this route
        if (!auth()->check() || auth()->user()->role !== $role) {
            
            // If they are logged in but have the wrong role, bounce them to their proper dashboard
            if (auth()->check()) {
                return redirect()->route('dashboard'); 
            }
            
            // Otherwise bounce to login
            return redirect()->route('login');
        }

        return $next($request);
    }
}
