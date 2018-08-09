<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_question', function (Blueprint $table) {
            $table->increments('id');
            $table->string("question_title")->comment("问题标题");
            $table->string("question_desc")->comment("问题描述");
            $table->string("master_name")->comment("提问题用户姓名");
            $table->string("master_phone")->comment("提问题用户联系方式");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_question');
    }
}
