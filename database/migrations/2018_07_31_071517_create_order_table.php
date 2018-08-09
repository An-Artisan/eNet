<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number',255)->comment("订单号");
            $table->integer('userid')->comment("订单用户id");
            $table->string('goods_id',255)->comment("商品id");
            $table->string('single_price',255)->comment("商品单价");
            $table->double('sum_price',11,2)->comment("商品总价格");
            $table->string('count',255)->comment("商品总数");
            $table->integer('use_red_packet')->comment("是否使用过红包,1=>使用,0=>未使用");
            $table->double('distribution_fee',11,2)->comment("配送费");
            $table->double('red_packet_price',11,2)->comment("红包价格");
            $table->double('real_pay_price',11,2)->comment("实际付款价格");
            $table->integer('transport_id')->comment("运送信息id");
            $table->integer('pay_way')->comment("付款方式,1=>在线支付,0=>货到付款");
            $table->integer('pay_status')->comment("支付状态,1=>已经支付,0=>未支付,2=>货到付款,3=>已经失效");
            $table->integer("order_status")->comment("0=> 待付款，1=>待发货，2=> 待收货, 3=>已收货");
            $table->integer('distribution_id')->comment("配送方式id");
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
        Schema::dropIfExists('order');
    }
}
