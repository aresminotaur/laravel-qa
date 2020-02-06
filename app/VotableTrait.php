<?php
namespace App;

/**
 *
 */
trait VotableTrait
{
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
