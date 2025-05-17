<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPatientOrGuest
{
    public function handle($request, Closure $next)
    {
        // Allow access if:
        // 1. User is not logged in (guest)
        // 2. User is logged in as a patient
        if (!Auth::check() || (Auth::check() && Auth::user()->isPatient())) {
            return $next($request);
        }

        // Redirect all other users (staff/admins) to admin dashboard
        return redirect()->route('admin.dashboard')
               ->with('error', 'Staff members must use the admin panel to manage appointments.');
    }
}