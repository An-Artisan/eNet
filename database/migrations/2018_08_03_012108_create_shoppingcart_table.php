<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingcartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppingcart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("userid")->comment("用户id");
            $table->string("goods_id",255)->comment("商品id列表");
            $table->string("single_price",255)->comment("商品单价列表");
            $table->double("sum_price",12,2)->comment("商品总价");
            $table->string("count",255)->comment("商品数量");
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
        Schema::dropIfExists('shoppingcart');
    }
}
