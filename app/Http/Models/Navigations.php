<?php

namespace App\Http\Models;


class Navigations extends Generic
{
    public function __construct()
    {
        parent::__construct('navigations', 'idNavigation');
    }

    public function getAllSortedByPosition()
    {
        return \DB::table('navigations')
            ->select('*')
            ->orderBy('position','asc')
            ->get();
    }
}