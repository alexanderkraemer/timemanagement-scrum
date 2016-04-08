<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $task = new \App\Task();
        $task->id = 1;
        $task->sprint_id = 1;
        $task->nr= '1.1';
        $task->name = 'Testtask';
        $task->estimatedtime = '00:30:00';
        $task->save();
    }
}
