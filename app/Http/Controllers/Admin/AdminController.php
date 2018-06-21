<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Interfaces\Admin\IAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Generic;
use App\Http\Models\Users;

class AdminController extends Controller implements IAdmin
{
    private $viewData = [];
    
    public function index($page = null) {
        if(empty($page))
            return view("admin.index", $this->viewData);

        $table = str_replace("-", "", $page);

        return AdminController::getAll($table);
    }

    public function insert(Request $request) {
        
    }

    public function update(Request $request) {
        $id = $request->get("id");
        $view = explode(".", $request->get("viewName"))[1];
        $table = $request->get("tableName");
        $data = $request->get("data");

        $generic = new Generic($table, null);

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function delete(Request $request) {
        $ids = $request->get("ids");
        $view = explode(".", $request->get("viewName"))[1];
        $table = $request->get("tableName");

        $generic = new Generic($table, null);

        $generic->deleteMultiple($ids);

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function getById(Request $request) {
        $id = $request->get("id");
        $table = $request->get("tableName");

        $type = "App\\Http\\Models\\" . $table;
        $model = new $type($table);

        $result = $model->getById($id);

        return !empty($result) ? response()->json(json_encode($result), 200) : response()->json(null, 500);
    }

    public static function getAll($table, $view = null) {
        $view = empty($view) ? $table : $view;
        $type = "App\\Http\\Models\\" . $table;

        $model = new $type($table);

        return view("admin." . $view, ["tableData" => $model->getAll(), "tableName" => $view])->render();
    }

}