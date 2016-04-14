<?php

use Illuminate\Database\Seeder;

class problems_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('problems')->insert([
            'title' => str_random(10),
            'description' => 'description:' . str_random(20),
            'time_limit' => '10',
            'memory_limit' => '10',
            'difficulty' => 'easy',
            'classification' => '0',
            'input_description' => str_random(10),
            'output_description' => str_random(10),
            'created_by' => str_random(10),
            'contest' => random_int(1, 10)
        ]);
    }
}
