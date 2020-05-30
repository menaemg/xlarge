<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    // $url = 'https://api.adorable.io/avatars/240/'. rand(1,1000);
    // $contents = file_get_contents($url);
    // $imageName =  $faker->md5() . '.png';
    // Storage::disk('images')->put( $imageName , file_get_contents($url));
    // return [
    //     'name' => $faker->name,
    //     'email' => $faker->unique()->safeEmail,
    //     'email_verified_at' => now(),
    //     'rule' => rand(1,3),
    //     'image' => 'http://127.0.0.1:8000///storage/images/' . $imageName,
    //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     'remember_token' => Str::random(10),
    // ]
});
