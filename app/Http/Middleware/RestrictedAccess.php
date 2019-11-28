<?php

namespace App\Http\Middleware;

use Closure;

class RestrictedAccess
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
        $roles = ['admin', 'superadmin'];

        if (! in_array($request->user()->roles, $roles)) {
            abort('403');
        }

        return $next($request);
    }
}
