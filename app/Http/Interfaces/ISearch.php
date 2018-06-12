<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface ISearch
{
    public function search(Request $request);
}