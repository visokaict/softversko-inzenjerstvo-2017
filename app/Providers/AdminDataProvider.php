<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminDataProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer("*", function ($view) {
            $items = [
                ["name" => "Overview", "url" => ""],
                ["name" => "Users", "url" => "users"],
                ["name" => "Roles", "url" => "roles"],
                ["name" => "Game jams", "url" => "game-jams"],
                ["name" => "Game submissions", "url" => "game-submissions"],
                ["name" => "Game categories", "url" => "game-categories"],
                ["name" => "Game criteria", "url" => "game-criteria"],
                ["name" => "Comments", "url" => "comments"],
                ["name" => "Images", "url" => "images"],
                ["name" => "Navigations", "url" => "navigations"],
                ["name" => "Poll", "url" => "poll"],
                ["name" => "Reports", "url" => "reports"],
                ["name" => "Platforms", "url" => "platforms"]
            ];

            view()->share('viewName', $view->getName());
            $view->currentUrl = url()->current();
            $view->adminNav = $items;
        });
    }

    public function register()
    {
        
    }
}
