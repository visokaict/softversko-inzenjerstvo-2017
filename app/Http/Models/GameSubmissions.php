<?php

namespace App\Http\Models;

// idGameSubmission, idGameJam, idTeaserImage, idCoverImage, idUserCreator, description, createdAt, editedAt, numOfViews, numOfDownloads, isBlocked, numberOfVotes, sumOfVotes
class GameSubmissions extends Generic
{
    public function __construct()
    {
        parent::__construct('gamesubmissions', 'idGameSubmission');
    }

    //
    // methods
    //

    public function insert()
    {

    }

    public function get($offset = 0, $limit = 9, $sort)
    {
        $sort["name"] = "gamesubmissions." . $sort["name"];

        $games = \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamesubmissions.idTeaserImage', '=', 'images.idImage')
            ->select(\DB::raw('*, (gamesubmissions.sumOfVotes / gamesubmissions.numberOfVotes) as rating'))
            ->offset($offset)
            ->limit(9)
            ->orderBy($sort["name"] === "gamesubmissions.rating" ? "rating" : $sort["name"], $sort["direction"])
            ->get();

        foreach ($games as $game) {
            $game->{"categories"} = $this->getCategories($game->idGameSubmission);
        }

        return $games;
    }

    public function getCategories($id)
    {
        return \DB::table('gamesubmissions_categories')
            ->join('gamecategories', 'gamesubmissions_categories.idCategory', '=', 'gamecategories.idGameCategory')
            ->select('*')
            ->where('gamesubmissions_categories.idGameSubmission', '=', $id)
            ->get();
    }

    public function getByUserAndGameJam($idUser, $idGameJam) {
        return \DB::table($this->tableName)
            ->select('*')
            ->where('idUserCreator', '=', $idUser)
            ->where('idGameJam', '=', $idGameJam)
            ->first();
    }
    
    public function increaseViews($id)
    {
        return \DB::table($this->tableName)
            ->where('idGameSubmission', '=', $id)
            ->increment('numOfViews', 1);
    }

    public function getOne($id){
        return \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamesubmissions.idCoverImage', '=', 'images.idImage')
            ->where('idGameSubmission', '=', $id)
            ->first();
    }

    public function getAllSearched($queryString, $offset = 0, $limit = 6)
    {
        return \DB::table($this->tableName)
            ->join('images', 'gamesubmissions.idCoverImage', '=', 'images.idImage')
            ->select(["images.alt", "images.path", "gamesubmissions.title", "gamesubmissions.description", "gamesubmissions.idGameSubmission"])
            ->where('gamesubmissions.title', 'like', '%' . $queryString . '%')
            ->orWhere('gamesubmissions.description', 'like', '%' . $queryString . '%')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countAllSearched($queryString)
    {
        return \DB::table($this->tableName)
            ->where('gamesubmissions.title', 'like', '%' . $queryString . '%')
            ->orWhere('gamesubmissions.description', 'like', '%' . $queryString . '%')
            ->count();
    }

    public function getScreenShots($id)
    {
        return \DB::table('gamesubmissions_screenshots')
            ->join('images', 'gamesubmissions_screenshots.idImage', '=', 'images.idImage')
            ->where('gamesubmissions_screenshots.idGameSubmission', '=', $id)
            ->get();
    }
}