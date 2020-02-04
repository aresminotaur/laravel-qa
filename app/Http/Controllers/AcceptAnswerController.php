<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    // when we route to a controller that doesn't have predefined actions
    // laravel assumes we're calling to the invoke function
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);
        $answer->question->acceptBestAnswer($answer);
        return back();
    }
}
