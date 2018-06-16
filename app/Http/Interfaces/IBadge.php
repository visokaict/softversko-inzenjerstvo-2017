<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IBadge
{
    public function get(Request $request, $gameId);
    public function add(Request $request, $gameId);
    public function remove(Request $request, $gameId);
}