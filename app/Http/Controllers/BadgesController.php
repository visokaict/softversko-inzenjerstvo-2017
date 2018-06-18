<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IBadge;
use App\Http\Models\GameBadges;
use App\Http\Models\GameSubmissions;
use Illuminate\Http\Request;

class BadgesController extends Controller implements IBadge
{
    public function get(Request $request, $gameId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error"=>["message"=>"Invalid game id!"]], 400);
        }

        try {
            $badges = new GameBadges();
            $result = $badges->getByGameSubmissionId($gameId);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }
    }

    public function add(Request $request, $gameId, $badgeId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error"=>["message"=>"Invalid game id!"]], 400);
        } else if (!preg_match("/^\d+$/", $badgeId)) {
            return response()->json(["error"=>["message"=>"Invalid badge id!"]], 400);
        }
        $userId = $request->attributes->get('userInfo')->idUser;

        //
        $bages = new GameBadges();
        $games = new GameSubmissions();
        $gameSubmission = $games->getById($gameId);

        if(empty($gameSubmission))
        {
            //game doesn't exist
            return response()->json(["error"=>["message"=>"Game doesn't exist!"]], 400);
        }

        if($gameSubmission->idUserCreator == $userId)
        {
            //user is owner
            return response()->json(["error"=>["message"=>"User creator cannot add badges!"]], 400);
        }

        $gameBages = $bages->getAllByGameId($gameId);


        $isAdded = false;
        $userHasAddedIt = false;

        foreach($gameBages as $gb)
        {
            if($gb->idBadge == $badgeId)
            {
                 $isAdded = true;
                 break;
            }

            if($gb->idUser == $userId)
            {
                $userHasAddedIt = true;
                break;
            }
        }

        if($isAdded)
        {
            //user is owner
            return response()->json(["error"=>["message"=>"Badge already added!"]], 400);
        }

        if($userHasAddedIt)
        {
            //user is owner
            return response()->json(["error"=>["message"=>"User has already added badge!"]], 400);
        }

        // insert and return data
        $newBadge = $games->addBadge($gameId, $badgeId, $userId);

        return response()->json($newBadge, 201);
    }

    public function remove(Request $request, $gameId, $badgeId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error"=>["message"=>"Invalid game id!"]], 400);
        } else if (!preg_match("/^\d+$/", $badgeId)) {
            return response()->json(["error"=>["message"=>"Invalid badge id!"]], 400);
        }

        $userId = $request->attributes->get('userInfo')->idUser;

        try {
            $games = new GameSubmissions();
            $gameBadge = $games->getOneGameSubmissionBadgeById($badgeId);

            // da li postoji badge
            if(empty($gameBadge))
            {
                //game doesn't exist
                return response()->json(["error"=>["message"=>"Game badge doesn't exist!"]], 400);
            }

            // da li badge pripada zapravo tom game submission-u
            if($gameBadge->idGameSubmission != $gameId)
            {
                //badge doesn't exist for that game
                return response()->json(["error"=>["message"=>"Game badge doesn't exist!"]], 400);
            }

            // da li ga prava osoba brise [aka, user creator = user id
            if($gameBadge->idUser != $userId)
            {
                // its not the badges owner
                return response()->json(["error"=>["message"=>"You cannot remove others badge!"]], 400);
            }

            $games->removeBadge($badgeId);

            return response()->json(null, 204);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }
    }

}
