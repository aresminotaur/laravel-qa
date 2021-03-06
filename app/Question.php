<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{

    // including trait
    use VotableTrait;

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

    // public function setBodyAttribute($value)
    // {
    //   // cleaning the input text before it is stored
    //   $this->attributes['body'] = clean($value);
    // }

    // accessor
    public function getUrlAttribute()
    {
      return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
      return $this->created_at->diffForHumans();
    }

    public function getAvatarAttribute()
    {
      // Pasting from gravatar.com
      $email = "someone@somewhere.com";
      $size = 32;
      return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }


    public function getStatusAttribute()
    {
      if($this->answers_count > 0){
        if ($this->best_answer_id) {
          return "answer-accepted" ;
        }
        return "answered";
      }
      else {
        return "unanswered";
      }
    }

    public function getBodyHtmlAttribute()
    {
      return clean($this->bodyHtml());
    }

    // relationship between question and answers
    public function answers()
    {
      return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    // accepting best answer
    public function acceptBestAnswer(Answer $answer)
    {
      $this->best_answer_id = $answer->id;
      $this->save();
    }

    // favorites table
    public function favorites()
    {
      return $this->belongsToMany(User::class, 'favorites')->withTimeStamps();
      // timestamps() ensures timestamps are added also, duh
    }

    public function isFavorited()
    {
      return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
      return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
      return $this->favorites()->count();
    }

    // because we donot want to change the length from the Model
    // but would rather have it changed in the view
    public function getExcerptAttribute()
    {
      return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
      // His accent sucks
      // Because the body will probably be in html syntax or something,
      // We must parse it to normal human text
      return \Parsedown::instance()->text($this->body);
    }


    // making redundant by using trait
    // // relationship with votables table
    // public function votes()
    // {
    //   return $this->morphToMany(User::class, 'votable');
    //   // morphed to many users
    // }
    //
    // public function upVotes()
    // {
    //   // sum of all up votes
    //   return $this->votes()->wherePivot('vote', 1);
    // }
    //
    // public function downVotes()
    // {
    //   // sum of all down votes
    //   return $this->votes()->wherePivot('vote', -1);
    // }

}
