<?php

use Illuminate\Database\Seeder;

class ZeiterfassungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $entry = new \App\Zeiterfassung();
        $entry->id = 1;
        $entry->task_id = 1;
        $entry->user_id = 1;
        $entry->timeneeded = '01:30:00';
        $entry->timestillneeded = '00:30:00';
    }
}
