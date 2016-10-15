<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Gate::denies('permission', 'access.admin')) {
            return abort(404);
        }

        return $next($request);
    }
}
