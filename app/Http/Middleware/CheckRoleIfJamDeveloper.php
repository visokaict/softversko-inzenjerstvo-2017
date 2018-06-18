<?php

namespace App\Http\Middleware;

use App\Http\Models\Roles;
use Closure;

class CheckRoleIfJamDeveloper
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

        $canAccess = Roles::arrayOfRolesHasRoleByName($userRoles[0], 'jamDeveloper');

        if($canAccess)
        {
            return $next($request);
        }

        return back()->with('message', 'You don\'t have Jam Developer role to access this resource!');
    }
}
