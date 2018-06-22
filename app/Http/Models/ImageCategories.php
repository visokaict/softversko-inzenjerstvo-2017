<?php

namespace App\Http\Models;

class ImageCategories extends Generic
{
    public function __construct()
    {
        parent::__construct('imagecategories', 'idImageCategory');
    }
}