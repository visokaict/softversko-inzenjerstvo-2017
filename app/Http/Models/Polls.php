<?php

namespace App\Http\Models;

//
// this class is responsible for tables:
// [pollQuestions, pollAnswers, pollVotes]
//

use Illuminate\Support\Facades\DB;

class Polls
{

    public function getActivePollQuestion()
    {
        return DB::table('pollQuestions')
            ->select('*')
            ->where('active', '=', 0)
            ->first();
    }

    public function getAnswersByQuestionId($id)
    {
        return DB::table('pollAnswers')
            ->select('*')
            ->where('idPollQuestion', '=', $id)
            ->get();
    }

    public function pollVote($userId, $idPollQuestion, $idPollAnswer)
    {
        try {
            DB::table('pollVotes')
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