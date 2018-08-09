<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTypeSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_type_second', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_type_id')->comment("一级分类id");
            $table->string('goods_type_second_name',255)->comment("二级类型名");
            $table->string('goods_type_second_desc',255)->comment("二级类型描述");
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
        Schema::dropIfExists('goods_type_second');
    }
}
