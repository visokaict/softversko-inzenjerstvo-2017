<?php

namespace App\Http\Models;

// idImage, idImageCategory, alt, path
class GameBadges extends Generic
{
    public function __construct()
    {
        parent::__construct('gamebadges', 'idGameBadges');
    }

    public function getByGameSubmissionId($gameId)
    {
        return \DB::table('gamesubmissions_badges')
            ->join('gamebadges', 'gamesubmissions_badges.idBadge', '=', 'gamebadges.idGameBadges')
            ->join('images', 'images.idImage', '=', 'gamebadges.idImage')
            ->where('gamesubmissions_badges.idGameSubmission', '=', $gameId)
            ->get();
    }

    public function getAllByGameId($idGame)
    {
        return \DB::table('gamesubmissions_badges')
            ->where('idGameSubmission', '=', $idGame)
            ->get();
    }
}