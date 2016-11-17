<?php

namespace App\Http\Middleware;

use Closure;

class Impersonate
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
      // Check if the User has Already Impersonate and Is Admin ...
        if($request->session()->has('impersonate'))
        {
            auth()->onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}
