<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sdk_id',50)->comment('渠道id');
            $table->string('user_id')->comment('用户id');
            $table->string('user_name')->comment('用户名');
            $table->integer('share_num')->default(0)->comment('分享次数');
            $table->string('share_type')->comment('分享类型');
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
        Schema::dropIfExists('share_log');
    }
}
