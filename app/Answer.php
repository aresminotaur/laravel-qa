<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'user_id',
    ];

    // eloquent events
    public static function boot()
    {
      parent::boot();

      // When a record is created
      static::created(function($answer)
      {
        $answer->question->increment('answers_count');
      });

      // When a record is edited and saved OR created and saved
      //    static::saved(function($answer)
      //    {
      //      echo "Answer saved\n";
      //    });

      // When a record is deleted
      static::deleted(function($answer)
      {
        $answer->question->decrement('answers_count');
      });

    }

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

    public function getStatusAttribute()
    {
      return $this->isBest() ? 'answer-accepted' : '';
    }

    public function getIsBestAttribute()
    {
      return $this->isBest();
    }

    public function isBest()
    {
      return $this->question->best_answer_id === $this->id;
    }

    // relationship with votables table
    public function votes()
    {
      return $this->morphToMany(User::class, 'votable');
      // morphed to many users
    }

    public function upVotes()
    {
      // sum of all up votes
      return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
      // sum of all down votes
      return $this->votes()->wherePivot('vote', -1);
    }

}
