<?php

namespace App\Http\Middleware;

use Closure;

class CheckForSuperAdmin
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
        if ($request->user()->type != "super_admin") {
            return redirect('home');
        }
        return $next($request);
    }
}
