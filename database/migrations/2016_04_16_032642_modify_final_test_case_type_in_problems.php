<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFinalTestCaseTypeInProblems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->string('final_test_case_address_in');//最终测试输入用例路径
            $table->string('final_test_case_address_out');//最终测试输出用例路径
            $table->string('random_key');//随机生成的特征码
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            $table->dropColumn('final_test_case_address_in');//最终测试输入用例路径
            $table->dropColumn('final_test_case_address_out');//最终测试输出用例路径
            $table->dropColumn('random_key');//随机生成的特征码
        });
    }
}
