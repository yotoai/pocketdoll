<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRucksackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rucksack', function (Blueprint $table) {
            $table->increments('id')->comment('背包id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('goods_id')->comment('娃娃id');
            $table->integer('num')->comment('娃娃数量');
            $table->enum('status',['0','1'])->default('0')->comment('提取状态');
            $table->timestamp('withdraw_time')->nullable()->comment('提取时间');
            $table->timestamp('gain_time')->nullable()->comment('获取时间');
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
        Schema::dropIfExists('user_rucksack');
    }
}
