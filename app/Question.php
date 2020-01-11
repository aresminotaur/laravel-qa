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
    }


}
