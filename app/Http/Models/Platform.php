<?php

namespace App\Http\Models;

class Platform extends Generic
{
    public function __construct()
    {
        parent::__construct('platforms', 'idPlatform');
    }

}