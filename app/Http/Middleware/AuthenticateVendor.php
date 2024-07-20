<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateVendor
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
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        if (! $user->isActive()) {
            Auth::logout();

            return redirect()->route('login')->withErrors(['email' => 'Your account has been disabled. Please contact Admin.']);
        }

        if (! $user->isVendor()) {
            return redirect()->route('customer.dashboard');
        }

        return $next($request);
    }
}
