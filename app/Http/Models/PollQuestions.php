<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class PollQuestions extends Polls {

    public function __construct() {
        parent::__construct('pollquestions', 'idPollQuestion');
    }

}