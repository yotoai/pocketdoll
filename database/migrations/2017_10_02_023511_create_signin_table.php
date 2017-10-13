<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigninTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signin', function (Blueprint $table) {
            $table->increments('id')->comment('签到id');
            $table->integer('user_id')->comment('用户id');
            $table->timestamp('sign_time')->comment('签到时间');
            $table->enum('status',['0','1'])->comment('签到状态');
            $table->integer('sign_day_num')->comment('签到天数');
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
        Schema::dropIfExists('signin');
    }
}
