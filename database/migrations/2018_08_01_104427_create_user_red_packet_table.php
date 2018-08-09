<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRedPacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_red_packet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->comment("用户id");
            $table->integer('red_packet_id')->comment("红包id");
            $table->integer('is_receive')->comment("1=>已领取,0=>未领取");
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
        Schema::dropIfExists('user_red_packet');
    }
}
