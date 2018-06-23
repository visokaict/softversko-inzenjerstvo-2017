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

    public function getAll() {
        return \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('gamejams', 'gamesubmissions.idGameJam', '=', 'gamejams.idGameJam')
            ->join('images', 'gamesubmissions.idCoverImage', '=', 'images.idImage')
            ->select(\DB::raw("gamesubmissions.*, gamejams.title as gameJam, (gamesubmissions.sumOfVotes / gamesubmissions.numberOfVotes) as rating, users.username, images.path as cover"))
            ->get();
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

    public function getCategoriesIds($id)
    {
        $categories = $this->getCategories($id);
        $result =[];
        foreach($categories as $c)
        {
            $result[] = $c->idCategory;
        }

        return $result;
    }

    public function getByUserAndGameJam($idUser, $idGameJam)
    {
        return \DB::table($this->tableName)
            ->select('*')
            ->where('idUserCreator', '=', $idUser)
            ->where('idGameJam', '=', $idGameJam)
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

    public function increaseViews($id)
    {
        return \DB::table($this->tableName)
            ->where('idGameSubmission', '=', $id)
            ->increment('numOfViews', 1);
    }

    public function getOne($id)
    {
        return \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamesubmissions.idCoverImage', '=', 'images.idImage')
            ->where('idGameSubmission', '=', $id)
            ->first();
    }

    public function getScreenShots($id)
    {
        return \DB::table('gamesubmissions_screenshots')
            ->join('images', 'gamesubmissions_screenshots.idImage', '=', 'images.idImage')
            ->where('gamesubmissions_screenshots.idGameSubmission', '=', $id)
            ->get();
    }

    public function getDownloadFiles($id)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->select(['gamesubmissions_downloadfiles.*', 'downloadfiles.*', 'platforms.classNameForIcon'])
            ->join('downloadfiles', 'gamesubmissions_downloadfiles.idDownloadFile', '=', 'downloadfiles.idDownloadFile')
            ->join('platforms', 'downloadfiles.idPlatform', '=', 'platforms.idPlatform')
            ->where('gamesubmissions_downloadfiles.idGameSubmission', '=', $id)
            ->get();
    }

    public function getGamePlatformId($id)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->select('downloadfiles.idPlatform')
            ->join('downloadfiles', 'gamesubmissions_downloadfiles.idDownloadFile', '=', 'downloadfiles.idDownloadFile')
            ->where('gamesubmissions_downloadfiles.idGameSubmission', '=', $id)
            ->first();
    }

    public function saveRelationshipWithDownloadFile($idGameSubmission, $idFile)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->insert([
                "idGameSubmission" => $idGameSubmission,
                "idDownloadFile" => $idFile,
            ]);
    }

    public function removeRelationshipWithDownloadFile($idGame)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->where('idGameSubmission', '=', $idGame)
            ->delete();
    }

    public function addBadge($idGame, $idBadge, $idUser)
    {
        //insert and return value
        $id = \DB::table('gamesubmissions_badges')
            ->insertGetId([
                "idGameSubmission" => $idGame,
                "idBadge" => $idBadge,
                "idUser" => $idUser,
            ]);

        return \DB::table('gamesubmissions_badges')
            ->join('gamebadges', 'gamesubmissions_badges.idBadge', '=', 'gamebadges.idGameBadges')
            ->join('images', 'images.idImage', '=', 'gamebadges.idImage')
            ->where('gamesubmissions_badges.idGameSubmissionsBadge', '=', $id)
            ->first();
    }

    public function getOneGameSubmissionBadgeById($id)
    {
        return \DB::table('gamesubmissions_badges')
            ->where('idGameSubmissionsBadge', '=', $id)
            ->first();
    }

    public function removeBadge($idBadge)
    {
        return \DB::table('gamesubmissions_badges')
            ->where('idGameSubmissionsBadge', '=', $idBadge)
            ->delete();
    }

    public function getAllUsersGameSubmissions($userId, $offset = 0, $limit = 6)
    {
        $return = [];

        $games = \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamesubmissions.idTeaserImage', '=', 'images.idImage')
            ->select(\DB::raw('*, (gamesubmissions.sumOfVotes / gamesubmissions.numberOfVotes) as rating'))
            ->where("gamesubmissions.idUserCreator", "=", $userId);


        $return["count"] = $games->count();

        $games->offset($offset)
            ->limit($limit);
        $return["result"] = $games->get();

        foreach ($return["result"] as $game) {
            $game->{"categories"} = $this->getCategories($game->idGameSubmission);
        }

        return $return;
    }

    public function getAllUsersGameSubmissionsWins($userId, $offset = 0, $limit = 6)
    {
        $return = [];

        $games = \DB::table($this->tableName)
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamesubmissions.idTeaserImage', '=', 'images.idImage')
            ->select(\DB::raw('*, (gamesubmissions.sumOfVotes / gamesubmissions.numberOfVotes) as rating'))
            ->where("gamesubmissions.idUserCreator", "=", $userId)
            ->where("gamesubmissions.isWinner", '=', '1');


        $return["count"] = $games->count();

        $games->offset($offset)
            ->limit($limit);
        $return["result"] = $games->get();

        foreach ($return["result"] as $game) {
            $game->{"categories"} = $this->getCategories($game->idGameSubmission);
        }

        return $return;
    }

    public function saveGameCategories($model)
    {
        return \DB::table('gamesubmissions_categories')
            ->insertGetId($model);
    }

    public function removeAllCategories($idGame){
        return \DB::table('gamesubmissions_categories')
            ->where('idGameSubmission', '=', $idGame)
            ->delete();
    }

    public function userOwnsGameSubmission($idUser, $idGameSubmission)
    {
        //todo
    }

    public function getGameIdByDownloadFileId($id)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->select('*')
            ->where('idDownloadFile', '=', $id)
            ->first();
    }

    public function getDownloadFileIdByGameId($id)
    {
        return \DB::table('gamesubmissions_downloadfiles')
            ->select('*')
            ->where('idGameSubmission', '=', $id)
            ->first();
    }
}