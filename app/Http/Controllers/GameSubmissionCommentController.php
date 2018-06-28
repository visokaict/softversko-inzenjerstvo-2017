<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IGameSubmissionComment;
use App\Http\Models\Comments;
use App\Http\Models\GameSubmission_Comment;
use Illuminate\Http\Request;

class GameSubmissionCommentController extends Controller implements IGameSubmissionComment
{

    public function get(Request $request, $gameId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error" => ["message" => "Invalid game id!"]], 400);
        }

        try {
            $comments = new GameSubmission_Comment();
            $result = $comments->getByGameSubmissionId($gameId);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }
    }

    public function add(Request $request, $gameId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error" => ["message" => "Invalid game id!"]], 400);
        }
        if (!$request->has('text')) {
            return response()->json(["error" => ["message" => "Missing comment text!"]], 400);
        }

        $commentText = $request->get('text');

        // validate comment text
        if (!preg_match("/^[\w\.\s\,\"\'\!\?\:\;\[\]]+$/", $commentText)) {
            return response()->json(["error" => ["message" => "Comment text has unsupported characters!"]], 400);
        }

        //insert comment
        try {
            $time = time();
            $userId = $request->attributes->get('userInfo')->idUser;

            $comment = new Comments();
            $commentId = $comment->insertGetId([
                "text" => $commentText,
                "idUserCreator" => $userId,
                "createdAt" => $time,
                "editedAt" => $time,
            ]);

            if (empty($commentId)) {
                return response()->json(["error" => ["message" => "Comment not inserted!"]], 500);
            }

            $gameComment = new GameSubmission_Comment();
            $gameCommentId = $gameComment->insertGetId([
                "idGameSubmission" => $gameId,
                "idComment" => $commentId,
            ]);

            $result = $gameComment->getOneById($gameCommentId);


            return response()->json($result, 200);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }

    }

    public function edit(Request $request, $gameId, $commentId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error" => ["message" => "Invalid game id!"]], 400);
        }
        if (!preg_match("/^\d+$/", $commentId)) {
            return response()->json(["error" => ["message" => "Invalid comment id!"]], 400);
        }

        $commentText = $request->get('text');

        // validate comment text
        if (!preg_match("/^[\w\.\s\,\"\'\!\?\:\;\[\]]+$/", $commentText)) {
            return response()->json(["error" => ["message" => "Comment text has unsupported characters!"]], 400);
        }

        try {
            $gsComments = new GameSubmission_Comment();
            $commentGSData = $gsComments->getById($commentId);


            //comment doesn't exists
            if (empty($commentGSData)) {
                return response()->json(["error" => ["message" => "Comment doesn't exist!"]], 400);
            }

            // comment is not for this game submission
            if ($gameId != $commentGSData->idGameSubmission) {
                return response()->json(["error" => ["message" => "Comment doesn't exist!"]], 400);
            }

            $comments = new Comments();
            $commentData = $comments->getById($commentGSData->idComment);


            $userId = $request->attributes->get('userInfo')->idUser;


            if ($commentData->idUserCreator != $userId) {
                return response()->json(["error" => ["message" => "You cannot update comments from different users!"]], 400);
            }

            $comments->update($commentData->idComment, [
                "text"=> $commentText
            ]);

            return response()->json(null, 204);

        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function remove(Request $request, $gameId, $commentId)
    {
        if (!preg_match("/^\d+$/", $gameId)) {
            return response()->json(["error" => ["message" => "Invalid game id!"]], 400);
        }
        if (!preg_match("/^\d+$/", $commentId)) {
            return response()->json(["error" => ["message" => "Invalid comment id!"]], 400);
        }

        try {
            $gsComments = new GameSubmission_Comment();
            $commentGSData = $gsComments->getById($commentId);


            //comment doesn't exists
            if (empty($commentGSData)) {
                return response()->json(["error" => ["message" => "Comment doesn't exist!"]], 400);
            }

            // comment is not for this game submission
            if ($gameId != $commentGSData->idGameSubmission) {
                return response()->json(["error" => ["message" => "Comment doesn't exist!"]], 400);
            }

            $comments = new Comments();
            $commentData = $comments->getById($commentGSData->idComment);


            $userId = $request->attributes->get('userInfo')->idUser;
            //todo
            if ($commentData->idUserCreator != $userId) {
                return response()->json(["error" => ["message" => "You cannot remove comments from different users!"]], 400);
            }

            $comments->delete($commentData->idComment);

            return response()->json(null, 204);

        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }
}
