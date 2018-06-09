<?php

namespace App\Http\Controllers;

use App\Http\Models\Navigations;
use App\Http\Interfaces\IGameSubmission;
use Illuminate\Http\Request;
use App\Http\Models\GameSubmissions;
use Illuminate\Support\Facades\Input;

class GameSubmissionController extends Controller implements IGameSubmission
{

    private $viewData;

    //
    // this function is used as AJAX and normal REQUEST handler
    public function getFilteredGames(Request $request)
    {

        $page = empty(Input::get("page")) ? 1 : Input::get("page");
        $sortBy = empty(Input::get("sort")) ? "new" : Input::get("sort");
        $sort["name"] = "createdAt";
        $sort["direction"] = "desc";

        switch($sortBy){
            case "old":
                $sort["direction"] = "asc";
                break;
            case "top":
                $sort["name"] = "rating";
                break;
            case "views":
                $sort["name"] = "numOfViews";
                break;
            case "download":
                $sort["name"] = "numOfDownloads";
                break;
        }

        $games = new GameSubmissions();
        // todo: add combobox games per page 6 9 12 all?
        $getGames = $games->get(($page - 1) * 9, 9, $sort);

        $this->viewData["games"] = $getGames;
        $this->viewData["gamesCount"] = $games->count();
        $this->viewData["currentPage"] = $page;
        $this->viewData["currentSort"] = $sortBy;

        if ($request->ajax()) {
            return view('ajax.loadGames', $this->viewData)->render();
        }

        //
        // add navigagtion for page only if not ajax
        $this->setupNavigation();

        return view('gameSubmissions.games', $this->viewData);
    }

    public function insert(Request $request)
    {
        // TODO: Implement insert() method.
    }

    public function edit(Request $request)
    {
        // TODO: Implement edit() method.
    }

    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }

    private function setupNavigation(){
        $navs = new Navigations();
        $this->viewData['navigation'] = $navs->getAllSortedByPosition();
    }
}
