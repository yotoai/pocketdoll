<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatchdollLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catchdoll_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->comment('用户id');
            $table->integer('goods_id')->comment('商品id');
            $table->enum('status',['-1','1'])->default('-1')->comment('是否提现');
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
        Schema::dropIfExists('catchdoll_log');
    }
}
