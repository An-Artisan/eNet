<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->comment("登录用户名");
            $table->string('openid')->comment("微信授权openid");
            $table->tinyInteger('sex')->comment("性别");
            $table->string('nickname')->nullable(true)->comment("昵称");
            $table->string('phone')->nullable(true)->comment("手机号码");
            $table->string('email')->unique()->nullable(true);
            $table->string('password');
            $table->string('photo')->comment("用户头像");
            $table->tinyInteger('is_phone')->default(0)->comment("是否启用：1，验证过手机；0，没有验证过手机");
            $table->string('qrcode_address',255)->comment("二维码地址");
            $table->string('invate_code',255)->comment("邀请码");
            $table->integer('parent_id')->comment("父级id");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
