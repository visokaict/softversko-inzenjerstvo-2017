<?php

namespace App\Http\Middleware;

use App\Http\Models\Users;
use Closure;

class CheckIfAPILoggedIn
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
        //get auth token from cookie
        $authToken = $request->cookie('authToken');
        //
        // check if exist
        if(empty($authToken))
        {
            //user missing access token
            return response()->json(["error"=>["message"=>"Missing access token!"]], 403);
        }

        //
        //try to decode it
        try{
            $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);
            $token = $encrypter->decrypt($authToken);
        }
        catch (\Exception $e)
        {
            return response()->json(null, 500);
        }

        //
        // get user by token if exist
        $user = new Users();
        $userData = $user->getByAccessToken($token);

        if(empty($userData))
        {
            //user not authorized
            return response()->json(["error"=>["message"=>"User not authorized!"]], 401);
        }

        //
        // all good
        $request->attributes->add(["userInfo" => $userData]);
        return $next($request);
    }
}
