<?php

namespace App\Http\Models;

//
// this class is responsible for tables:
// [pollQuestions, pollAnswers, pollVotes]
//

use Illuminate\Support\Facades\DB;

class Polls extends Generic
{
    public function __construct($tableName = null, $idName = null) {
        parent::__construct($tableName === null ? "pollquestions" : $tableName, $idName === null ? "idPollQuestion" : $idName);
    }

    public function getAll() {
        $questions = DB::table('pollquestions')
            ->select('*')
            ->get();

        foreach($questions as $question) {
            $question->{"answers"} = $this->getAnswersByQuestionId($question->idPollQuestion);
        }

        return $questions;
    }

    public function getAnswersByQuestionId($id) {
        return DB::table('pollanswers')
            ->select('*')
            ->where('idPollQuestion', '=', $id)
            ->get();
    }

    public function getByIdAnswer($id) {
        return DB::table('pollanswers')
            ->select('*')
            ->where("idPollAnswer", $id)
            ->first();
    }

    public function getActivePollQuestion()
    {
        return DB::table('pollquestions')
            ->select('*')
            ->where('active', '=', 1)
            ->first();
    }

    public function setActivePollQuestion($id) {
        DB::table('pollquestions')
            ->update(['active' => 0]);
        
        return DB::table('pollquestions')
            ->where('idPollQuestion', $id)
            ->update(['active' => 1]);
    }

    public function pollVote($userId, $idPollQuestion, $idPollAnswer)
    {
        try {
            DB::table('pollvotes')
                ->insert([
                    'idUserVoter' => $userId,
                    'idPollQuestion' => $idPollQuestion,
                    'idPollAnswer' => $idPollAnswer,
                    'createdAt' => time(),
                ]);

            DB::table('pollAnswers')
                ->where('idPollAnswer', '=', $idPollAnswer)
                ->increment('numberOfVotes', 1);

            return true;
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            //duplicate entry [ user already voted]
            return false;
        }

        return false;
    }

}