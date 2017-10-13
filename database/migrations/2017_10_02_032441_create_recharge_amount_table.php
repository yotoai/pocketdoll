<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_amount', function (Blueprint $table) {
            $table->increments('id')->comment('充值额度id');
            $table->string('title')->comment('充值额度的名称');
            $table->integer('coin_num')->comment('额度数量');
            $table->integer('award_num')->comment('奖励金币数量');
            $table->float('price',10,2)->comment('对应金额');
            $table->string('pic',255)->default('')->comment('对应图片');
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
        Schema::dropIfExists('recharge_amount');
    }
}
