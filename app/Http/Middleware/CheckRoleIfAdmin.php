<?php

namespace App\Http\Middleware;

use App\Http\Models\Roles;
use Closure;

class CheckRoleIfAdmin
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
        $userRoles = $request->session()->get('roles');

        $canAccess = Roles::arrayOfRolesHasRoleByName($userRoles[0], 'admin');

        if($canAccess)
        {
            return $next($request);
        }

        return back()->with('message', 'You don\'t have role to access this resource!');
    }
}
