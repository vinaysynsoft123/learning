<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAgent
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'Agent') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'You must be an agent to access this page.');
    }
}
