<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class PollAnswers extends Polls {

    public function __construct() {
        parent::__construct('pollanswers', 'idPollAnswer');
    }

}