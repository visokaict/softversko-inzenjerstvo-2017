<?php
/**
 * Created by PhpStorm.
 * User: Urukalo
 * Date: 5/26/2018
 * Time: 4:29 PM
 */

namespace App\Http\Models;


class Roles extends Generic
{
    public function __construct()
    {
        parent::__construct('roles', 'idRoles');
    }

    public function getAllAvailable()
    {
        return \DB::table('roles')
            ->select('*')
            ->where('isAvailableForUser','=', 1) //bool => true
            ->get();
    }
}