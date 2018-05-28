<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Models\Users;

class UserDataProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('layouts.frontEnd', function ($view) {
            //$users = new Users();
            $users = new Users();
            $user = null;
            if(session()->has('user')){
                $user = $users->getById(session()->get('user')[0]->idUser);
            }
            $view->userDataProvider = $user;
        });
    }
    public function register()
    {
        
    }
}
