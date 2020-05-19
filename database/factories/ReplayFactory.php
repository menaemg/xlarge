<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Replay;
use App\User;
use App\Comment;
use Faker\Generator as Faker;

$factory->define(Replay::class, function (Faker $faker) {
    return [
        'content' => $faker->text(50),
        'user_id' => User::all()->random()->id,
        'comment_id' => Comment::all()->random()->id
    ];
});
