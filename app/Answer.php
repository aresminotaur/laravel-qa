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

    public function getCreatedDateAttribute()
    {
      return $this->created_at->diffForHumans();
    }

    // eloquent events
    public static function boot()
    {
      parent::boot();

      // When a record is created
      static::created(function($answer)
      {
        $answer->question->increment('answers_count');
        $answer->question->save();
      });

      // When a record is edited and saved OR created and saved
      //    static::saved(function($answer)
      //    {
      //      echo "Answer saved\n";
      //    });
    }

}
