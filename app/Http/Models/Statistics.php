<?php

namespace App\Http\Models;

class Statistics
{
    private $limit = 7;

    public function getForChart($tableName, $tableTimeName = 'createdAt'){
        return \DB::table($tableName)
            ->select(\DB::raw('FROM_UNIXTIME(`'.$tableTimeName.'`, \'%Y-%m-%d\') as ndate, count(*) as data_count'))
            ->groupBy('ndate')
            ->limit($this->limit)
            ->get();
    }

    public function getTableCount($tableName){
        return \DB::table($tableName)
            ->count();
    }

}