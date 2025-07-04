<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has admin role
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        // Redirect to login page if not admin
        return redirect()->route('login')->with('error', 'You do not have admin access.');
    }
}
