<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $url = "https://picsum.photos/id/" . rand(1,50) . "/400/300.jpg";
    $contents = file_get_contents($url);
    $imageName = $faker->md5() . '.jpg';
    Storage::disk('images')->put( $imageName , file_get_contents($url));
    return [
        'title' => $faker->sentence(3),
        'content' => $faker->Text(3000),
        'user_id' => User::all()->random()->id,
        'user_id' => Category::all()->random()->id,
        'image' => $imageName
    ];
});
