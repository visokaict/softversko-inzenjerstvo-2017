<?php

namespace App\Http\Models;


class Platforms extends Generic
{
    public function __construct()
    {
        parent::__construct('platforms', 'idPlatform');
    }
}