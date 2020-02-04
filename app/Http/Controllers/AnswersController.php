<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    // the reason we're setting question paramenter in each method is to follow the nested resource format in route

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
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        // validate will return validated data
        $answer->update($request->validate([
          'body' => 'required',
        ]));

        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer was updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {

    }
}
