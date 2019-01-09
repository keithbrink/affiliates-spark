<?php

namespace KeithBrink\AffiliatesSpark\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Affiliate
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
        if (!Auth::user()->isAffiliate()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
