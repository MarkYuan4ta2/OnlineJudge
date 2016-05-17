<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_problems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id');
            $table->integer('problem_id');
            $table->integer('total_submission');
            $table->integer('total_accepted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contest_problems');
    }
}
