<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->comment("用户id");
            $table->string('name',255)->comment("收货姓名");
            $table->string('phone',255)->comment("收货联系电话");
            $table->string('city',255)->comment("收货城市");
            $table->text('address')->comment("收货详细地址");
            $table->integer('is_default')->comment("是否为默认地址, 1=>是默认地址,0=>不为默认地址");
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
        Schema::dropIfExists('transport');
    }
}
