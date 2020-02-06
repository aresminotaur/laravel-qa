<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    // constructor
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
      // capture the vote for some reason with a laravel helper function
      $vote = (int) request()->vote;

      auth()->user()->voteQuestion($question, $vote);

      return back();

    }
}
