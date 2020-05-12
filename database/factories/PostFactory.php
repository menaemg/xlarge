<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'content' => $faker->Text(3000),
        'user_id' => User::all()->random()->id,
        'image' => 'https://picsum.photos/id/'. rand(1,1000) . '/400/300',
    ];
});
