<?php

use Illuminate\Database\Seeder;

class classification_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classifications')->insert([
            'name' => str_random(10),
            'created_by' => random_int(1,5),
            'problems_count' => random_int(5, 10),
        ]);
    }
}
