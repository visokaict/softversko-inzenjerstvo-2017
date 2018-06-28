<?php

namespace App\Http\Models;

// idGameJam title description idCoverImage startDate endDate votingEndDate content lockSubmissionAfterSubmitting 
// othersCanVote isBlocked idUserCreator numOfViews
class GameJams extends Generic
{
    public function __construct()
    {
        parent::__construct('gamejams', 'idGameJam');
    }

    //
    // methods
    //

    public function insert($title, $description, $coverImage, $startDate, $endDate, $votingEndDate, $content, $lockSubmissionAfterSubmitting, $othersCanVote, $idUserCreator)
    {
        $insertData = [
            'title' => $title,
            'description' => $description,
            'idCoverImage' => $coverImage,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'votingEndDate' => $votingEndDate,
            'content' => $content,
            'lockSubmissionAfterSubmitting' => $lockSubmissionAfterSubmitting,
            'othersCanVote' => $othersCanVote,
            'isBlocked' => 0,
            'idUserCreator' => $idUserCreator,
            'numOfViews' => 0,
            'createdAt'=> time(),
        ];
        return parent::insertGetId($insertData);
    }

    public function getAll() {
        return \DB::table($this->tableName)
            ->join('users', 'gamejams.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamejams.idCoverImage', '=', 'images.idImage')
            ->select("gamejams.*", "users.username", "images.path as cover")
            ->get();
    }

    public function getAllWhereVotingEndDateNotFinished()
    {
        return \DB::table($this->tableName)
            ->select("idGameJam", "title", "startDate", "endDate", "votingEndDate", \DB::raw("(SELECT count(*) FROM gamejams_participants WHERE gamejams_participants.idGameJam = gamejams.idGameJam) as countJoined"))
            ->where('votingEndDate', '>', time())
            ->get();
    }

    public function getAllUsersGameJams($userId, $offset = 0, $limit = 6)
    {
        $return = [];

        $result = \DB::table($this->tableName)
            ->join('users', 'gamejams.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamejams.idCoverImage', '=', 'images.idImage')
            ->where('gamejams.idUserCreator', '=', $userId)
            ->select("*", \DB::raw("(SELECT count(*) FROM gamejams_participants WHERE gamejams_participants.idGameJam = gamejams.idGameJam) as countJoined"));

        $return["count"] = $result->count();

        $result->offset($offset)
            ->limit($limit);
        $return["result"] = $result->get();

        return $return;
    }

    public function getFilteredGameJams($filter, $offset = 0, $limit = 6)
    {
        $return = [];

        $result = \DB::table($this->tableName)
            ->join('users', 'idUserCreator', '=', 'users.idUser')
            ->join('images', 'idCoverImage', '=', 'images.idImage')
            ->select("*", \DB::raw("(SELECT count(*) FROM gamejams_participants WHERE gamejams_participants.idGameJam = gamejams.idGameJam) as countJoined, (SELECT count(*) FROM gamesubmissions WHERE gamesubmissions.idGameJam = gamejams.idGameJam) as countSubmissions"));

        // in progress
        if ($filter === "progress") {
            $count = $result->where("startDate", "<", time())
                ->where("endDate", ">", time())->count();

            $result->offset($offset)
                ->limit($limit)
                ->where("startDate", "<", time())
                ->where("endDate", ">", time());
        } // upcoming
        else if ($filter === "upcoming") {
            $count = $result->where("startDate", ">", time())->count();

            $result->offset($offset)
                ->limit($limit)
                ->where("startDate", ">", time());
        }

        $return["count"] = $count;
        $return["result"] = $result->get();

        return $return;
    }

    public function getOne($id)
    {
        $gameJam = \DB::table($this->tableName)
            ->join('users', 'gamejams.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamejams.idCoverImage', '=', 'images.idImage')
            ->select('*')
            ->where('gamejams.idGameJam', '=', $id)
            ->first();

        $gameJam->{"participants"} = $this->getParticipants($id);
        $gameJam->{"criteria"} = $this->getCriteria($id);
        $gameJam->{"submissions"} = $this->getSubmissions($id);
        $gameJam->{"countSubmissions"} = $this->countByJoinedId("gamesubmissions", $id);

        return $gameJam;
    }

    public function getSubmissions($id) {
        return \DB::table('gamesubmissions')
            ->join('images', 'gamesubmissions.idTeaserImage', '=', 'images.idImage')
            ->join('users', 'gamesubmissions.idUserCreator', '=', 'users.idUser')
            ->select('*')
            ->where('idGameJam', '=', $id)
            ->get();
    }

    public function getParticipants($id) {
        return \DB::table('gamejams_participants')
            ->join('users', 'gamejams_participants.idUser', '=', 'users.idUser')
            ->select('*')
            ->where('gamejams_participants.idGameJam', '=', $id)
            ->get();
    }

    public function getCriteria($id)
    {
        return \DB::table('gamejams_criterias')
            ->join('gamecriteria', 'gamejams_criterias.idCriteria', '=', 'gamecriteria.idGameCriteria')
            ->select('*')
            ->where('gamejams_criterias.idGameJam', '=', $id)
            ->get();
    }

    public function insertCriteria($idGameJam, $idCriteria)
    {
        return \DB::table('gamejams_criterias')
            ->insert([
                'idGameJam' => $idGameJam,
                'idCriteria' => $idCriteria,
            ]);
    }

    public function deleteCriteria($idGameJam, $idGameCriteria){
        return \DB::table('gamejams_criterias')
            ->where("idGameJam", "=", $idGameJam)
            ->where("idCriteria", "=", $idGameCriteria)
            ->delete();
    }

    public function increaseViews($id)
    {
        \DB::statement("UPDATE gamejams SET numOfViews = numOfViews + 1 WHERE idGameJam = " . $id);
    }

    public function joinUserToGameJam($idUser, $idGameJam) {
        return \DB::table('gamejams_participants')
            ->insertGetId(["idUser" => $idUser, "idGameJam" => $idGameJam]);
    }

    public function removeUserFromGameJam($idUser, $idGameJam) {
        return \DB::table('gamejams_participants')
            ->where('idUser', '=', $idUser)
            ->where('idGameJam', '=', $idGameJam)
            ->delete();
    }

    public function userAlreadyJoined($idUser, $idGameJam) {
        return \DB::table('gamejams_participants')
            ->select('*')
            ->where('idUser', '=', $idUser)
            ->where('idGameJam', '=', $idGameJam)
            ->exists();
    }

    public function userOwnsGameJam($idUser, $idGameJam) {
        return \DB::table('gamejams')
            ->select('*')
            ->where('idUserCreator', '=', $idUser)
            ->where('idGameJam', '=', $idGameJam)
            ->exists();
    }
    
    public function getAllSearched($queryString, $offset = 0, $limit = 6) {
        return \DB::table($this->tableName)
            ->join('images', 'gamejams.idCoverImage', '=', 'images.idImage')
            ->select(["images.alt", "images.path", "gamejams.title", "gamejams.description", "gamejams.idGameJam"])
            ->where('gamejams.title', 'like', '%' . $queryString . '%')
            ->orWhere('gamejams.description', 'like', '%' . $queryString . '%')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countAllSearched($queryString)
    {
        return \DB::table($this->tableName)
            ->where('gamejams.title', 'like', '%' . $queryString . '%')
            ->orWhere('gamejams.description', 'like', '%' . $queryString . '%')
            ->count();
    }
}