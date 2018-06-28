<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Interfaces\Admin\IAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Generic;
use App\Http\Models\PollQuestions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminController extends Controller implements IAdmin
{
    private $viewData = [];

    private $columns = [
        "gamecategories" => [
            // field name, field type
            ["name", "text"]
        ],
        "gamecriteria" => [
            ["name", "text"],
            ["description", "text"]
        ],
        "imagecategories" => [
            ["name", "text"]
        ],
        "roles" => [
            ["name", "text"],
            ["text", "text"],
            ["isAvailableForUser", "checkbox"],
            ["description", "text"]
        ],
        "users" => [
            ["email", "text"],
            ["username", "text"],
            ["password", "text"],
            ["avatarImagePath", "text"],
            ["isBanned", "checkbox"]
        ],
        "platforms" => [
            ["name", "text"],
            ["classNameForIcon", "text"]
        ],
        "navigations" => [
            ["path", "text"],
            ["name", "text"],
            ["position", "text"]
        ],
        "reports" => [
            ["solved", "checkbox"]
        ],
        "pollquestions" => [
            ["text", "text"]
        ],
        "pollanswers" => [
            ["text", "text"],
            ["idPollQuestion", "number"]
        ]
    ];

    public static function getTypeByTableName($tableName){
        $result = "App\\Http\\Models\\";
        $c = "";
        switch ($tableName){
            case 'comments': $c = "Comments"; break;
            case 'downloadfiles': $c = "DownloadFiles"; break;
            case 'gamebadges': $c = "GameBadges"; break;
            case 'gamecategories': $c = "GameCategories"; break;
            case 'gamecriteria': $c = "GameCriteria"; break;
            case 'gamejams': $c = "GameJams"; break;
            case 'gamesubmission_comment': $c = "GameSubmission_Comment"; break;
            case 'gamesubmissions': $c = "GameSubmissions"; break;
            case 'generic': $c = "Generic"; break;
            case 'imagecategories': $c = "ImageCategories"; break;
            case 'images': $c = "Images"; break;
            case 'navigations': $c = "Navigations"; break;
            case 'platform': $c = "Platform"; break;
            case 'platforms': $c = "Platforms"; break;
            case 'pollanswers': $c = "PollAnswers"; break;
            case 'pollquestions': $c = "PollQuestions"; break;
            case 'polls': $c = "Polls"; break;
            case 'reports': $c = "Reports"; break;
            case 'roles': $c = "Roles"; break;
            case 'statistics': $c = "Statistics"; break;
            case 'users': $c = "Users"; break;
            case 'utilities': $c = "Utilities"; break;
        }

        return $result . $c;
    }

    public function index($page = null) {
        if(empty($page)) {
            return view("admin.index", $this->viewData);
        }

        return AdminController::getAll(str_replace("-", "", $page));
    }

    public function block(Request $request) {
        $id = $request->get("id");
        $table = $request->get("tableName");
        $view = explode(".", $request->get("viewName"))[1];
        //$type = "App\\Http\\Models\\" . $table;
        $type = AdminController::getTypeByTableName($table);

        $model = new $type($table);

        $model->update($id, ["isBlocked" => $request->get("isBlocked")]);

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function insert(Request $request) {
        $table = $request->get("tableName");
        $view = explode(".", $request->get("viewName"))[1];
        
        $model = new Generic($table);

        $insertData = [];

        foreach($this->columns[$table] as $column) {
            $value = $request->get($column[0]);
            if($column[1] === "checkbox") {
                $insertData[$column[0]] = $request->has($column[0]) ? 1 : 0;
            }
            else if(!empty($value)) {
                if($column[1] === "text" || $column[1] === "number") {
                    $insertData[$column[0]] = $value;
                }
            }
        }

        if(count($insertData)){
            $result = $model->insertGetId($insertData);

            if(empty($result)) {
                return response()->json(["message" => "Failed to insert data."], 500);
            }
        }
        else {
            return response()->json(["message" => "No data provided."], 400);
        }

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function update(Request $request) {
        $id = $request->has("hiddenId") ? $request->get("hiddenId") : $request->get("id");
        $table = $request->get("tableName");
        $view = explode(".", $request->get("viewName"))[1];

        $model = new Generic($table);

        $updateData = [];

        foreach($this->columns[$table] as $column) {
            $value = $request->get($column[0]);
            if($column[1] === "checkbox") {
                $updateData[$column[0]] = $request->has($column[0]) ? 1 : 0;
            }
            else if(!empty($value)) {
                if($column[1] === "text") {
                    $updateData[$column[0]] = $value;
                }
            }
        }

        $result = $model->update($id, $updateData);

        if(empty($result)) {
            return response()->json(["message" => "Not updated."], 500);
        }

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function delete(Request $request) {
        $ids = $request->get("ids");
        $count = count(explode(".", $request->get("viewName")));
        $view = $count > 1 ? explode(".", $request->get("viewName"))[1] : $request->get("viewName");
        
        $table = $request->get("tableName");

        $generic = new Generic($table, null);

        $generic->deleteMultiple($ids);

        return AdminController::getAll($table, "ajax." . $view);
    }

    public function getById(Request $request) {
        $id = $request->get("id");
        $table = $request->get("tableName");

        //$type = "App\\Http\\Models\\" . $table;
        $type = AdminController::getTypeByTableName($table);
        $model = new $type($table);

        $result = $model->getById($id);

        return !empty($result) ? response()->json(json_encode($result), 200) : response()->json(null, 500);
    }

    public static function getAll($table, $view = null) {
        $table = strtolower($table);

        $view = empty($view) ? $table : $view;
        //$type = "App\\Http\\Models\\" . $table;

        $type = AdminController::getTypeByTableName($table);

        $model = new $type($table);
        $result = $model->getAll();
        
        return view("admin." . $view, ["tableData" => $result, "tableName" => $table])->render();
    }

}