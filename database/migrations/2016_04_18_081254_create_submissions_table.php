<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('problem_id');
            $table->string('language');
            $table->integer('run_time')->default(-1);
            $table->timestamp('created_at');
            $table->longText('code');
            $table->longText('compile_result');
            $table->string('run_result');
            $table->enum('result', ['Accepted', 'Runtime Error', 'Time Limit Exceeded', 'Memory Limit Exceeded', 'Compile Error', 'Wrong Answer', 'System Error', 'Waiting']);
            $table->integer('cheching')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('submissions');
    }
}
