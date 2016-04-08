<?php

use Illuminate\Database\Seeder;

class SprintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sprint = new \App\Sprint();
        $sprint->id = 1;
        $sprint->name = 'Präsentation';
        $sprint->save();
    }
}
