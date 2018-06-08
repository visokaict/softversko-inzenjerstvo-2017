<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface IContactUs
{
    public function pollVote(Request $request);
    public function postContact(Request $request);
}