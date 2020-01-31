<?php

namespace App\Policies;

use App\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the question.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function update(User $user, Question $question)
    {
        // Confirm if the current user owns the question
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  \App\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function delete(User $user, Question $question)
    {
        // Confirm if user is authorized AND if questions has no answers
        // The question can only be deleted by the authorized user if it has no answers
        return $user->id === $question->user_id && $question->answers_count < 1;
    }

}
