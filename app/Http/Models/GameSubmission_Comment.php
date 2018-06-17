<?php

namespace App\Http\Models;

class GameSubmission_Comment extends Generic
{
    public function __construct()
    {
        parent::__construct('gamesubmissions_comments', 'idGameSubmissionComment');
    }

    public function getByGameSubmissionId($gameId)
    {
        return \DB::table($this->tableName)
            ->select([
                'gamesubmissions_comments.*',
                'comments.*',
                'users.idUser',
                'users.username',
                'users.avatarImagePath',
            ])
            ->join('comments', 'comments.idComment', '=', 'gamesubmissions_comments.idComment')
            ->join('users', 'users.idUser', '=', 'comments.idUserCreator')
            ->where('gamesubmissions_comments.idGameSubmission', '=', $gameId)
            ->get();
    }

    public function getOneById($commentId)
    {
        return \DB::table($this->tableName)
            ->select([
                'gamesubmissions_comments.*',
                'comments.*',
                'users.idUser',
                'users.username',
                'users.avatarImagePath',
            ])
            ->join('comments', 'comments.idComment', '=', 'gamesubmissions_comments.idComment')
            ->join('users', 'users.idUser', '=', 'comments.idUserCreator')
            ->where('gamesubmissions_comments.idGameSubmissionComment', '=', $commentId)
            ->first();
    }
}