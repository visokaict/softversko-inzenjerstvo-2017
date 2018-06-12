<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ISearch;
use App\Http\Models\GameJams;
use App\Http\Models\GameSubmissions;
use Illuminate\Http\Request;

class SearchController extends Controller implements ISearch
{

    private $viewData = [];

    public function search(Request $request)
    {
        // make it more global
        // maybe some utilities model
        $pageSizeConfig = 6;

        $query = $request->query("q");
        if (empty($query)) {
            return back()->with('message', 'Please insert a search value first.');
        } else if (!preg_match("/^\w+$/", $query)) {
            return back()->with('message', 'Please insert only a text for search value.');
        }

        $gjManager = new GameJams();
        $gsManager = new GameSubmissions();

        $this->viewData["searchedText"] = $query;

        // so exec only some stuff
        $execGJ = true;
        $execGS = true;

        if ($request->ajax()) {
            $type = $request->query("type");
            switch ($type) {
                case "gameSubmissions":
                    $execGJ = false;
                    break;
                case "gameJams":
                    $execGS = false;
                    break;
            }
        }

        $pagePosition = $request->query("page");
        $pagePosition = empty($pagePosition) ? 1 : $pagePosition;


        if ($execGJ) {
            //
            // game jams stuff

            $this->viewData["gameJams"] = $gjManager->getAllSearched($query, ($pagePosition - 1) * $pageSizeConfig, $pageSizeConfig);
            $this->viewData["gamesJamsCount"] = $gjManager->countAllSearched($query);
            $this->viewData["currentPageGameJams"] = $pagePosition;
        }

        if ($execGS) {
            //
            // game submission stuff

            $this->viewData["gameSubmissions"] = $gsManager->getAllSearched($query, ($pagePosition - 1) * $pageSizeConfig, $pageSizeConfig);;
            $this->viewData["gameSubmissionsCount"] = $gsManager->countAllSearched($query);
            $this->viewData["currentPageGameSubmissions"] = $pagePosition;
        }

        if ($request->ajax()) {
            if (!$execGS) {
                return view('ajax.searchGameJams', $this->viewData)->render();
            }
            else if(!$execGJ) {
                return view('ajax.searchGameSubmissions', $this->viewData)->render();
            }
        }

        return view('other.search', $this->viewData);
    }

}
