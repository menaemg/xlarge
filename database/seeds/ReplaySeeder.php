<?php

use Illuminate\Database\Seeder;

class ReplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Replay::class, 50)->create();
    }
}
