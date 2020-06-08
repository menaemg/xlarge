<?php

use App\Like;
use App\User;
use App\Post;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = User::all()->toArray();

        foreach ( $posts as $post ){

            $user = User::all()->random()->id;

            Like::create([
                'user_id' => $user,
                'post_id' => $post['id']
            ]);

        }
    }
}
