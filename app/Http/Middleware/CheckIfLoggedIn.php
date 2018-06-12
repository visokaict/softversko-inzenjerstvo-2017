<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfLoggedIn
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
        if(!$request->session()->has('user'))
        {
            return back()->with('message', 'You are not logged in.');
        }
        return $next($request);
    }
}
