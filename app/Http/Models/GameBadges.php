<?php

namespace App\Http\Models;

// idImage, idImageCategory, alt, path
class GameBadges extends Generic
{
    public function __construct()
    {
        parent::__construct('gamebadges', 'idGameBadges');
    }
}