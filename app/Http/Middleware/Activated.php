<?php

namespace App\Http\Middleware;

use Closure;

class Activated
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
      // If You Are impersonating an Account Then ByPass this Middleware
      if($request->session()->has('impersonate'))
      {
        return $next($request);
      }
      // Scenario to Consider
      // User Active (paid) and on trial period = allow
      // User Active (paid) but Expired Trial = allow
      // User inactive (not paid) and on trial Period = allow (newly registered user)
      // User inactive (not paid) and Expired Trial = dont allow (show subscription page)

      // Allow Activated // Allow Not Expired Trial // Allow Not Expired Subscription
      if ($request->user()->activated == true || $request->user()->trialExpired() === false || $request->user()->subscriptionExpired() === false)
      {
        // Login User Has No Restriction then Continue to Use App

        return $next($request);

      }
      // Show Subscription Page For User inactive (not paid) and Expired Trial and Expired Subscription
      return redirect()->route('plans.index');
    }
}
