<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');//主键
            $table->string('title', 50);//题目标题
            $table->longText('description');//题目描述
            $table->integer('time_limit');//时间限制
            $table->integer('memory_limit');//内存限制
            $table->enum('difficulty', ['easy', 'middle', 'hard'])->default('easy');//难度
            $table->boolean('visible')->default(1);//是否可见
            $table->string('tag');//标签
            $table->longText('input_description');//输入描述
            $table->longText('output_description');//输出描述
            $table->integer('total_submit_number')->default(0);//总共提交数量
            $table->integer('total_accepted_number')->default(0);//总共通过数量
            $table->string('created_by');//创建者
            $table->integer('contest');//所属比赛
            $table->timestamps();//发布、更新时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('problems');
    }
}
