<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Models\Users;
use App\Http\Models\Navigations;

class FrontEndDataProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('layouts.frontEnd', function ($view) {
            $users = new Users();
            $user = $roles = null;
            if(session()->has('user')){
                $user = $users->getById(session()->get('user')[0]->idUser);
            }
            if(session()->has('roles')){
                $roles = $users->getAllRoles(session()->get('user')[0]->idUser);
            }
            $view->userDataProvider = $user;
            $view->rolesDataProvider = $roles;

            $navs = new Navigations();
            $view->navigation = $navs->getAllSortedByPosition();
        });
    }

    public function register()
    {
        
    }
}
