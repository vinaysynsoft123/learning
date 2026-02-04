<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAgent
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['Agent', 'Staff', 'Freelancer'])) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'You must be an agent, staff member, or freelancer to access this page.');
    }
}
