<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_title',255)->comment("商品标题");
            $table->string('goods_desc',255)->comment("商品描述");
            $table->double('goods_price',11,2)->comment("商品价格");
            $table->double('goods_original_price',11,2)->comment("商品原价");
            $table->integer('goods_type_id')->comment("商品对应的类别");
            $table->integer('goods_supplier_id')->comment("商品对应的供应商");
            $table->string('goods_photo',255)->comment("商品图片");
            $table->integer('goods_is_publish')->comment("1=>发布商品，0=>未发布商品");
            $table->integer('goods_count')->comment("商品数量");
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
        Schema::dropIfExists('goods');
    }
}
