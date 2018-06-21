<?php

namespace App\Http\Interfaces\Admin;

use Illuminate\Http\Request;

interface IUpdate
{
    public function users(Request $request);
}