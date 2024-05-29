<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role_as !== 'admin') {
            return redirect()->back()->with([
                'message' => 'You are not authorized to access this page.',
                'type' => 'error'
            ]);
        }

        return $next($request);
    }
}
