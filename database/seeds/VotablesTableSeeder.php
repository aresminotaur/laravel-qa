<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->delete();

        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1]; // $votes[0] or $votes[1]

        // each question will be voted up or down by a certain number of users
        foreach (Question::all() as $question) {
          for ($i=0; $i < rand(1, $numberOfUsers); $i++) {
              $user = $users[$i];
              $user->voteQuestion($question, $votes[rand(0, 1)]);
          }
        }

        // each question will be voted up or down by a certain number of users
        foreach (Answer::all() as $answer) {
          for ($i=0; $i < rand(1, $numberOfUsers); $i++) {
              $user = $users[$i];
              $user->voteAnswer($answer, $votes[rand(0, 1)]);
          }
        }
    }
}
