<?php

namespace App\Http\Models;


use Illuminate\Support\Facades\DB;

class Generic
{
    private $tableName;
    private $idName;

    public function __construct($tableName, $idName)
    {
        $this->tableName = $tableName;
        $this->idName = $idName;
    }

    public function getAll()
    {
        return DB::table($this->tableName)
            ->select('*')
            ->get();
    }

    public function getById($id)
    {
        DB::table($this->tableName)
            ->select('*')
            ->where( $this->idName,'=', $id)
            ->first();
    }

    public function insertGetId($model)
    {
        return DB::table($this->tableName)
            ->insertGetId($model);
    }

    public function delete($id)
    {
        return DB::table($this->tableName)
            ->where( $this->idName,'=', $id)
            ->delete();
    }
}