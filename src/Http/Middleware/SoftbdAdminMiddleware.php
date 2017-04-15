<?php

namespace SBD\Softbd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SBD\Softbd\Facades\Softbd;

class SoftbdAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guest()) {
            $user = Softbd::model('User')->find(Auth::id());

            return $user->hasPermission('browse_admin') ? $next($request) : redirect('/');
        }

        return redirect(route('softbd.login'));
    }
}
