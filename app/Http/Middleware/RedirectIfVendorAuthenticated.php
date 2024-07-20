<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfVendorAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  mixed  $guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (! Auth::guard($guard)->check()) {
                continue;
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user->isVendor()) {
                return redirect()->route('vendor.dashboard');
            }

            if ($user->hasPendingVendorRequest()) {
                session()->flash('alert-danger', trans('notifications.vendor_request_pending'));

                return redirect()->route('customer.dashboard');
            }
        }

        return $next($request);
    }
}
