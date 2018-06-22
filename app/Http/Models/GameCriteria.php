<?php

namespace App\Http\Models;

// idGameCriteria, name, description
class GameCriteria extends Generic
{
    public function __construct()
    {
        parent::__construct('gamecriteria', 'idGameCriteria');
    }

    //
    // methods
    //

    public function insert($name, $description)
    {
        $insertData = [
            'name' => $name,
            'description' => $description
        ];
        return parent::insertGetId($insertData);
    }

}