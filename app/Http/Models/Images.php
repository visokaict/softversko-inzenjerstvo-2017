<?php

namespace App\Http\Models;

// idImage, idImageCategory, alt, path
class Images extends Generic
{
    public function __construct()
    {
        parent::__construct('images', 'idImage');
    }

    //
    // methods
    //

    public function insert($category, $alt, $path)
    {
        $insertData = [
            'idImageCategory' => $category,
            'alt' => $alt,
            'path' => $path
        ];

        return parent::insertGetId($insertData);
    }

}