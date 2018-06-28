<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Statistics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{

    private $tablesMetaData = [];

    public function __construct()
    {
        $this->tablesMetaData = [
            ["resultName" => "users", "tableName"=> "users", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "gameJams", "tableName"=> "gamejams", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "games", "tableName"=> "gamesubmissions", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "reports", "tableName"=> "reports", "tableTimeColumnName"=> "createdAt"],//done

            ["resultName" => "comments", "tableName"=> "comments", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "downloadFiles", "tableName"=> "downloadfiles", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "images", "tableName"=> "images", "tableTimeColumnName"=> "createdAt"],//done
            ["resultName" => "polls", "tableName"=> "pollvotes", "tableTimeColumnName"=> "createdAt"], //done
        ];
    }

    public function getAllChart(Request $request)
    {
        try {
            $result = [];
            //get from all tables statistics

            $statManager = new Statistics();

            foreach($this->tablesMetaData as $item){
                $result[] = [$item['resultName'] =>  $statManager->getForChart($item['tableName'], $item['tableTimeColumnName'])];
            }

            return response()->json($result, 200);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }
    }

    public function getAllCount(Request $request)
    {
        try {
            $result = [];
            //get from all tables statistics

            $statManager = new Statistics();

            foreach($this->tablesMetaData as $item){
                $result[] = [$item['resultName'] =>  $statManager->getTableCount($item['tableName'])];
            }

            return response()->json($result, 200);
        } catch (\Exception $e) {
            //todo, log this in some file
            return response()->json(null, 500);
        }
    }
}
