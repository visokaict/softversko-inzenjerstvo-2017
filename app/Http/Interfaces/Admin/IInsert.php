<?php

namespace App\Http\Interfaces\Admin;

use Illuminate\Http\Request;

interface IInsert
{
    public function users(Request $request);
}