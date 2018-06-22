<?php

namespace App\Http\Models;

class GameCategories extends Generic
{
    public function __construct()
    {
        parent::__construct('gamecategories', 'idGameCategory');
    }

}