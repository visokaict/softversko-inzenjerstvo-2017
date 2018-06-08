<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IProfile
{
    public function edit(Request $request);
}