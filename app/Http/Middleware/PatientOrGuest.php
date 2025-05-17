<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PatientOrGuest
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->isPatient()) {
            return $next($request);
        }
        return redirect('/admin/dashboard');
    }
}