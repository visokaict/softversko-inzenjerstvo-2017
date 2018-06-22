<?php

namespace App\Http\Enums;

class ImageCategories
{
    public static $COVER = 1;
    public static $AVATAR = 2;
    public static $TEASER = 3;
    public static $BADGE = 4;
    public static $SCREENSHOT = 5;

    public static function getSavingFolderByEnum($category)
    {
        $result = 'images/unknown/';

        switch ($category)
        {
            case null:
                $result = 'downloads/';
                break;
            case ImageCategories::$COVER:
                $result = 'images/cover/';
                break;
            case ImageCategories::$AVATAR:
                $result = 'images/avatars/';
                break;
            case ImageCategories::$TEASER:
                $result = 'images/teasers/';
                break;
            case ImageCategories::$BADGE:
                $result = 'images/badges/';
                break;
            case ImageCategories::$SCREENSHOT:
                $result = 'images/screenshots/';
                break;
        }

        return $result;
    }
}
