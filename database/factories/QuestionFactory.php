<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), "."),
        'body' => $faker->paragraphs(rand(3, 7), "true"),
        'views' => rand(0, 10),
        // Now that we're using eloquent event to create this value,
        // We don't need it in the factory
        // 'answers_count' => rand(0, 10),
        'votes' => rand(-3, 10)
    ];
});
