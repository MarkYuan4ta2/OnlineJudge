<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Check if current user is admin group
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (null != $request->user() and $request->user()->is_admin > 0) {
            return $next($request);
        }
        return redirect()->guest('');
    }
}
