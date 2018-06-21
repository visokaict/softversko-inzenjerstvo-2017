<?php

namespace App\Http\Models;

class Comment extends Generic
{
    public function __construct()
    {
        parent::__construct('comments', 'idComment');
    }
}