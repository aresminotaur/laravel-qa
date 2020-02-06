<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
      return $this->hasMany(Question::class);
    }

    // accessor
    public function getUrlAttribute()
    {
      return '#';
    }

    public function getAvatarAttribute()
    {
      // Pasting from gravatar.com
      $email = "someone@somewhere.com";
      $size = 32;
      return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    // relationship between user and answers
    public function answers()
    {
      return $this->hasMany(Answer::class);
    }

    // relationship between user and favorites
    public function favorites()
    {
      return $this->belongsToMany(Question::class, 'favorites')->withTimeStamps();
      // timestamps() ensures timestamps are added also, duh
    }

    // relationship between user and votable questions
    public function voteQuestions()
    {
      return $this->morphedByMany(Question::class, 'votable');
      // user is morphed by question & answer model
    }

    // relationship between user and votable answers
    public function voteAnswers()
    {
      return $this->morphedByMany(Answer::class, 'votable');
      // user is morphed by question & answer model
    }

    public function voteQuestion(Question $question, $vote)
    {
      // check if user has already voted; if not, we will add a row to table
      // if so, and the vote is opposite, we will update the table row
      $voteQuestions = $this->voteQuestions();
      $vote_exists = $voteQuestions->where('votable_id', $question->id)->exists();
      if ($vote_exists)
      {
              $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
      }
      else
      {
          $voteQuestions->attach($question, ['vote' => $vote]);
      }

      $question->load('votes');
      $downVotes = (int) $question->downVotes()->sum('vote');
      $upVotes = (int) $question->upVotes()->sum('vote');

      $question->votes_count = $upVotes + $downVotes;
      $question->save();

    }

    public function voteAnswer(Answer $answer, $vote)
    {
      $voteAnswers = $this->voteAnswers();
      $vote_exists = $voteAnswers->where('votable_id', $answer->id)->exists();
      if ($vote_exists)
      {
              $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
      }
      else
      {
          $voteAnswers->attach($answer, ['vote' => $vote]);
      }

      $answer->load('votes');
      $downVotes = (int) $answer->downVotes()->sum('vote');
      $upVotes = (int) $answer->upVotes()->sum('vote');

      $answer->votes_count = $upVotes + $downVotes;
      $answer->save();

    }

}
