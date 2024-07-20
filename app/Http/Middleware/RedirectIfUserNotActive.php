<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUserNotActive
{
    /**
     * @param  mixed  $guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {

            /** @var \App\Models\User */
            $user = Auth::user();

            if (! $user->isActive()) {
                Auth::logout();

                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
