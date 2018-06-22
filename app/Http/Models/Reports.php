<?php

namespace App\Http\Models;

class Reports extends Generic
{
    public function __construct()
    {
        parent::__construct('reports', 'idReport');
    }

    public function getAll() {
        return \DB::table("reports")
            ->join("users", "reports.idUserCreator", "=", "users.idUser")
            ->select("*", "users.username")
            ->orderBy("idReport")
            ->get();
    }
}