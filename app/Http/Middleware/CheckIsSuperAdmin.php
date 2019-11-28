<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsSuperAdmin
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
        if ($request->user()->roles == 'superadmin') {
            return $next($request);
        } 

        return response()->json([
            'error' => 'You are not allowed to access superadmin page.',
        ], 403);

    }
}
