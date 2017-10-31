<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGainLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gain_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->comment('用户id');
            $table->string('goods_id')->comment('商品id');
            $table->string('num')->comment('提取的娃娃数量');
            $table->string('address_info')->comment('收货地址信息');
            $table->enum('status',['-1','1'])->default('-1')->comment('提现状态');
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
        Schema::dropIfExists('gain_log');
    }
}
