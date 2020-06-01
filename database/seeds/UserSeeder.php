<?php

use Illuminate\Database\Seeder;
use App\user;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'name'      => 'just user',
                'email'     => 'user@test.com',
                'password'  => Hash::make('password'),
                'image'     => 'http://127.0.0.1:8000///storage/images/user_avatar.png',
                'rule'      => 1
            ],
            [
                'name'      => 'editor man',
                'email'     => 'editor@test.com',
                'password'  => Hash::make('password'),
                'image'     => 'http://127.0.0.1:8000///storage/images/editor_avatar.png',
                'rule'      => 2
            ],
            [
                'name'      => 'super admin',
                'email'     => 'admin@test.com',
                'password'  => Hash::make('password'),
                'image'     => 'http://127.0.0.1:8000///storage/images/admin_avatar.png',
                'rule'      => 3
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
