<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
      // not creating a foreign request class for now

      // validating answer
      // $request->validate([
      //   'body' => 'required'
      // ]);

      // creating answer in answer table
      // $question->answers()->create(['body' => $answer->body, 'user_id' => \Auth::id()]);

      // OR

      // creating and validating answer at the same time (ugly but efficient)
      $question->answers()->create($request->
        validate(['body' => 'required' ])
        +
        ['user_id' => \Auth::id()]
      );

      // redirecting back to the page
      return back()->with('success', "Your answer has been posted successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
