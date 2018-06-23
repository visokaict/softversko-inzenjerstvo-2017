<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminDataProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer("*", function ($view) {
            $items = [
                ["name" => "Overview", "url" => "", "status" => "in-progress"],
                ["name" => "Users", "url" => "users", "status" => "done"],
                ["name" => "Game jams", "url" => "game-jams", "status" => "done"],
                ["name" => "Game submissions", "url" => "game-submissions", "status" => "done"],
                ["name" => "Game categories", "url" => "game-categories", "status" => "done"],
                ["name" => "Game criteria", "url" => "game-criteria", "status" => "done"],
                ["name" => "Image categories", "url" => "image-categories", "status" => "done"],
                ["name" => "Navigations", "url" => "navigations", "status" => "done"],
                ["name" => "Poll", "url" => "poll", "status" => "unfinished"],
                ["name" => "Roles", "url" => "roles", "status" => "done"],
                ["name" => "Reports", "url" => "reports", "status" => "unfinished"],
                ["name" => "Platforms", "url" => "platforms", "status" => "done"]
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
