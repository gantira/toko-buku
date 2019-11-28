<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsAdmin
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
        if ($request->user()->roles == 'admin') {
            return $next($request);
        } 

        return response()->json([
            'error' => 'You are not allowed to access admin page.',
        ], 403);

    }
}
