<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_log', function (Blueprint $table) {
            $table->increments('id')->comment('记录id');
            $table->string('order',100)->comment('订单id');
            $table->string('user_id')->comment('用户id');
            $table->string('porder_num')->comment('平台流水号');
            $table->integer('coin')->comment('充值额度id');
            $table->float('pay',8,2)->comment('充值金额');
            $table->enum('status',['-99','-1',1])->default('-1')->comment('支付状态');
            $table->string('status_des')->comment('状态描述');
            $table->timestamp('time')->nullable()->comment('充值时间');
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
        Schema::dropIfExists('recharge_log');
    }
}
