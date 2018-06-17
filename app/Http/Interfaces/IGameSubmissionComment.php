<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IGameSubmissionComment
{
    public function get(Request $request, $gameId);
    public function add(Request $request, $gameId);
    public function edit(Request $request, $gameId, $commentId);
    public function remove(Request $request, $gameId, $commentId);
}