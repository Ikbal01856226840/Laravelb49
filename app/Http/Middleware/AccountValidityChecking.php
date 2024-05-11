<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AccountValidityChecking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $today_date = Carbon::now()->format('Y-m-d');

        if ((auth()->user()->access_level !== 0) && (auth()->user()->account_valid_till < $today_date)) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
