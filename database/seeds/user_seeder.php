<?php

use Illuminate\Database\Seeder;

class user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(5).'@'.str_random(5).'.com',
            'password' => bcrypt('123456789'),
            'is_admin' => 0,
        ]);
    }
}
