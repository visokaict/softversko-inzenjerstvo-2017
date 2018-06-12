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
            'numOfViews' => 0
        ];
        return parent::insertGetId($insertData);
    }

    public function insertCriteria($idGameJam, $idCriteria) {
        return \DB::table('gamejams_criterias')
            ->insert([
                'idGameJam' => $idGameJam,
                'idCriteria' => $idCriteria,
            ]);
    }

    public function getAllWhereVotingEndDateNotFinished() {
        return \DB::table($this->tableName)
            ->select(["idGameJam", "title", "startDate", "endDate"])
            ->where('votingEndDate', '>', time())
            ->get();
    }

    public function getFilteredGameJams($filter, $offset = 0, $limit = 6) {
        $return = [];

        $result = \DB::table($this->tableName)
           ->join('users', 'gamejams.idUserCreator', '=', 'users.idUser')
           ->join('images', 'gamejams.idCoverImage', '=' ,'images.idImage')
           ->select("*");

        // in progress
        if($filter === "progress") {
            $count = $result->where("startDate", "<", time())
            ->where("endDate", ">", time())->count();

            $result->offset($offset)
                ->limit($limit)
                ->where("startDate", "<", time())
                ->where("endDate", ">", time());
        }
        // upcoming
        else if($filter === "upcoming") {
            $count = $result->where("startDate", ">", time())->count();

            $result->offset($offset)
                ->limit($limit)
                ->where("startDate", ">", time());
        }

        $return["count"] = $count;
        $return["result"] = $result->get();

        return $return;
    }

    public function getOne($id) {
        $gameJam = \DB::table($this->tableName)
            ->join('users', 'gamejams.idUserCreator', '=', 'users.idUser')
            ->join('images', 'gamejams.idCoverImage', '=' ,'images.idImage')
            ->select('*')
            ->where('gamejams.idGameJam', '=', $id)
            ->first();

        $gameJam->{"participants"} = $this->getParticipants($id);
        $gameJam->{"criteria"} = $this->getCriteria($id);
        $gameJam->{"countSubmissions"} = $this->countByJoinedId("gamesubmissions", $id);

        return $gameJam;
    }

    public function getParticipants($id) {
        return \DB::table('gamejams_participants')
            ->join('users', 'gamejams_participants.idUser', '=', 'users.idUser')
            ->select('*')
            ->where('gamejams_participants.idGameJam', '=', $id)
            ->get();
    }

    public function getCriteria($id) {
        return \DB::table('gamejams_criterias')
            ->join('gamecriteries', 'gamejams_criterias.idCriteria', '=', 'gamecriteries.idGameCriteria')
            ->select('*')
            ->where('gamejams_criterias.idGameJam', '=', $id)
            ->get();
    }

    public function increaseViews($id) {
        \DB::statement("UPDATE gamejams SET numOfViews = numOfViews + 1 WHERE idGameJam = " . $id);
    }

    public function getAllSearched($queryString, $offset = 0, $limit = 6){
        return \DB::table($this->tableName)
            ->join('images', 'gamejams.idCoverImage', '=' ,'images.idImage')
            ->select(["images.alt", "images.path", "gamejams.title", "gamejams.description", "gamejams.idGameJam"])
            ->where('gamejams.title', 'like', '%'.$queryString.'%')
            ->orWhere('gamejams.description', 'like', '%'.$queryString.'%')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }
}