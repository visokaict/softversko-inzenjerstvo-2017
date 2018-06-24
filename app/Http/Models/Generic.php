<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class Generic
{
    protected $tableName;
    private $idName;

    public function __construct($tableName = null, $idName = null)
    {
        $this->tableName = $tableName;
        $this->idName = !empty($idName) ? $idName : $this->getTableIdColumnName();
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
            ->where($this->idName, '=', $id)
            ->first();
    }

    public function insertGetId($model)
    {
        return DB::table($this->tableName)
            ->insertGetId($model);
    }

    public function insertGetRow($model)
    {
        $id = $this->insertGetId($model);
        return $this->getById($id);
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

    public function deleteMultiple($ids) {
        return DB::table($this->tableName)
            ->whereIn($this->idName, $ids)
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

    public function exist($id)
    {
        return \DB::table($this->tableName)
            ->where($this->idName, $id)
            ->exists();
    }

    public function getTableColumnNames()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->tableName);
    }

    public function getTableIdColumnName()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->tableName)[0];
    }

    public function increment($id, $columnName)
    {
        return \DB::table($this->tableName)
            ->where($this->idName, '=', $id)
            ->increment($columnName, 1);
    }

}