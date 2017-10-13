<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->comment('用户id');
            $table->string('openid',100)->comment('用户openid');
            $table->integer('coin')->comment('用户持有的金币数量');
            $table->integer('point')->comment('用户积分');
            $table->timestamp('login_time')->comment('登录时间');
            $table->string('nickname',255)->comment('用户昵称');
            $table->string('icon',255)->comment('用户头像');
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
        Schema::dropIfExists('user');
    }
}
