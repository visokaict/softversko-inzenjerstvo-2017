<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class Generic
{
    protected $tableName;
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
        return DB::table($this->tableName)
            ->select('*')
            ->where($this->idName,'=', $id)
            ->first();
    }

    public function insertGetId($model)
    {
        return DB::table($this->tableName)
            ->insertGetId($model);
    }

    public function update($id, $data)
    {
        return DB::table($this->tableName)
            ->where($this->idName, '=', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return DB::table($this->tableName)
            ->where($this->idName, '=', $id)
            ->delete();
    }

    public function count()
    {
        return DB::table($this->tableName)
            ->count();
    }

    public function countByJoinedId($tableName, $id)
    {
        return \DB::table($tableName)
            ->where($this->idName, '=', $id)
            ->count();
    }

}