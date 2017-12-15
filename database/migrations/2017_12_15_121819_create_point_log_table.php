<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sdk_id',50)->comment('渠道id');
            $table->string('user_id')->comment('用户id');
            $table->string('user_name')->comment('用户名');
            $table->integer('point_num')->default(0)->comment('获取积分的数量');
            $table->string('get_way')->comment('获取方式');
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
        Schema::dropIfExists('point_log');
    }
}
