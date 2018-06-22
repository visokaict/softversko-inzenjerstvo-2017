<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IGeneric
{
    public function insert(Request $request);
    public function edit(Request $request, $id);
    public function delete(Request $request, $id);
}