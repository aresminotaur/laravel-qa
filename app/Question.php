<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body',
    ];

    // define relationship with user
    public function user(){
      return $this->belongsTo(User::class);
    }

    // mutator
    public function SetTitleAttribute($value)
    {
      $this->attributes['title'] = $value;
      $this->attributes['slug'] = $value;
      // Actually, but no longer supported in this version:
      // $this->attributes['slug'] = str_slug($value);
    }

    // accessor
    public function getUrlAttribute()
    {
      return route('questions.show', $this->id);
    }

    public function getCreatedDateAttribute()
    {
      return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
      if($this->answers > 0){
        if ($this->best_answer_id) {
          return "answer-accepted" ;
        }
        return "answered";
      }
      else {
        return "unanswered";
      }
    }

}
