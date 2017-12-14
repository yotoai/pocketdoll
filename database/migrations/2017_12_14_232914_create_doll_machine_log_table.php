<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDollMachineLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doll_machine_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sdk_id',50)->comment('渠道id');
            $table->integer('doll_machine_id')->comment('娃娃机id');
            $table->string('doll_machine_name')->comment('娃娃机名称');
            $table->integer('catch_num')->comment('抓取次数');
            $table->integer('catched_num')->comment('抓到次数');
            $table->integer('lucky_model_catch_num')->comment('幸运模式抓取次数');
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
        Schema::dropIfExists('doll_machine_log');
    }
}
