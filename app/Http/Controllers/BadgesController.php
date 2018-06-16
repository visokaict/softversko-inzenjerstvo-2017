<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IBadge;
use Illuminate\Http\Request;

class BadgesController extends Controller implements IBadge
{

    public function get(Request $request, $gameId)
    {
    }

    public function add(Request $request, $gameId)
    {
    }

    public function remove(Request $request, $gameId)
    {
    }
}
