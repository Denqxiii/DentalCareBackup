<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to access this area.');
        }

        // Check both is_admin and role for backward compatibility
        $user = auth()->user();
        if (!($user->is_admin ?? false) && $user->role !== 'admin') {
            return redirect()->route('homepage')
                ->with('error', 'You must be an administrator to access this area.');
        }

        return $next($request);
    }
}