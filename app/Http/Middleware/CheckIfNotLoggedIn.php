<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfNotLoggedIn
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
        if($request->session()->has('user'))
        {
            return back()->with('messages', 'You are logged in.');
        }
        return $next($request);
    }
}
