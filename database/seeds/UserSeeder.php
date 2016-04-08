<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->firstname = 'Alexander';
        $user->lastname = 'Krämer';
        $user->name = 'AK';
        $user->email = 'office@alexanderkraemer.com';
        $user->password = bcrypt('domecue2008');
        $user->save();
    }
}
