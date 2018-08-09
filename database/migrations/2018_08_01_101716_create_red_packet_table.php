<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedPacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('red_packet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('red_packet_name')->comment("优惠券名称");
            $table->double('red_packet_price',11.2)->comment("优惠券金额");
            $table->integer('is_red_packet_threshold')->comment("是否是门槛红包,1=>门槛红包,0=>无门槛红包");
            $table->double('red_packet_threshold_price',11,2)->comment("满多少金额才会减免");
            $table->integer('is_publish')->comment("是否发布红包,1=>发布,0=>不发布");
            $table->timestamp('start_at')->comment("红包有效开始时间");
            $table->timestamp('end_at')->comment("红包有效结束时间");
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
        Schema::dropIfExists('red_packet');
    }
}
