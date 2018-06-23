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
        parent::__construct('roles', 'idRole');
    }

    public function getAllAvailable()
    {
        return \DB::table('roles')
            ->select('*')
            ->where('isAvailableForUser','=', 1) //bool => true
            ->get();
    }

    public static function arrayOfRolesHasRoleByName($roles, $roleName)
    {
        if(!empty($roles))
        {
            foreach($roles as $role)
            {
                if($role->name == $roleName)
                {
                    return true;
                }
            }
        }

        return false;
    }
}