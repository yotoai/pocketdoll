<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sdk_Id')->comment('渠道参数');
            $table->integer('user_id')->comment('用户id');
            $table->string('user_name')->default('')->comment('用户名称');
            $table->string('user_img')->default('')->comment('用户头像');
            $table->integer('coin')->default(0)->comment('用户所持金币');
            $table->integer('login_day')->default(1)->comment('登录天数');
            $table->enum('new_user_mission',['-1','1'])->default('-1')->comment('新用户任务是否完成');
            $table->timestamp('login_time')->comment('最近登录时间');
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
        Schema::dropIfExists('player');
    }
}
