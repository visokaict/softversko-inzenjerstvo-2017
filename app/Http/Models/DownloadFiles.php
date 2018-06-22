<?php

namespace App\Http\Models;

class DownloadFiles extends Generic
{
    public function __construct()
    {
        parent::__construct('downloadfiles', 'idDownloadFile');
    }
}