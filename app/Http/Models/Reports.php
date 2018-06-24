<?php

namespace App\Http\Models;

class Reports extends Generic
{
    public function __construct()
    {
        parent::__construct('reports', 'idReport');
    }

    public function getAll() {
        return \DB::table($this->tableName)
            ->join("users", "reports.idUserCreator", "=", "users.idUser")
            ->select("*", "users.username")
            ->where("solved", 0)
            ->orderBy("idReport")
            ->get();
    }

    public function userHasReportedGame($idGame, $idUser){
        return \DB::table($this->tableName)
            ->where('idUserCreator', '=', $idUser)
            ->where('idReportObject', '=', $idGame)
            ->exists();
    }
}