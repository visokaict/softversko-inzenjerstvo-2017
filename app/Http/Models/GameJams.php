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

    public function insertCriteria($idGameJam, $idCriteria){
        return \DB::table('gamejams_criterias')
            ->insert([
                'idGameJam' => $idGameJam,
                'idCriteria' => $idCriteria,
            ]);
    }

    public function getAllWhereVotingEndDateNotFinished(){
        return \DB::table($this->tableName)
            ->select(["idGameJam","title", "startDate", "endDate"])
            ->where('votingEndDate', '>', time())
            ->get();
    }
}