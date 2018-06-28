<?php

namespace App\Http\Models;

class Comments extends Generic
{
    public function __construct()
    {
        parent::__construct('comments', 'idComment');
    }
}