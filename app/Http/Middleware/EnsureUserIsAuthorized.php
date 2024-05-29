<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthorized
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in.render')->with([
                'message' => 'You need to be signed in to use this feature.',
                'type' => 'error'
            ]);
        }

        return $next($request);
    }
}
