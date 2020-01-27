<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    // relationship between question and answers
    public function question()
    {
      return $this->belongsTo(Question::class);
    }

    // relationship between user and answers
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    // accessor
    public function getBodyHtmlAttribute()
    {
      return \Parsedown::instance()->text($this->body);
    }

}
