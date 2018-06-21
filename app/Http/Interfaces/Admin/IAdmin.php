<?php

namespace App\Http\Interfaces\Admin;

use Illuminate\Http\Request;

interface IAdmin
{
    public function index($page = null);
    public function insert(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
    public function getById(Request $request);
    public static function getAll($table, $view = null);
}