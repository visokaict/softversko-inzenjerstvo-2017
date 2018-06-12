<?php

namespace App\Http\Models;

class Utilities
{
    private static function DateTimeFormater($format, $time = null)
    {
        if ($time == null) $time = time();
        return date($format, $time);
    }

    public static function PrintDate($time = null)
    {
        return self::DateTimeFormater("Y-m-d", $time);
    }

    public static function PrintDateTime($time = null)
    {
        return self::DateTimeFormater("Y-m-d h:i:s", $time);
    }
}