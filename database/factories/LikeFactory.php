<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use App\User;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    // $user = User::all()->random()->id;
    // $posts = DB::table('likes')
    //         ->where('user_id', '!=', $user)
    //     ->get();
    // if ($posts->count() > 1){
    //     $post = $posts->random()->id;
    // } elseif ($posts->count() == 1){
    //     $post = $posts->id;
    // } else {
    //     $post = 3;
    // }
    // return [
    //     'user_id' => $user,
    //     'post_id' => $post
    // ];
});
