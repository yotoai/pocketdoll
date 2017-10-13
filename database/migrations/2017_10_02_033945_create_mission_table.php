<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission', function (Blueprint $table) {
            $table->increments('id')->comment('任务id');
            $table->integer('type')->comment('任务种类');
            $table->string('contents',200)->comment('任务内容');
            $table->integer('award_id')->comment('奖励id');
            $table->integer('need_num')->comment('需要完成次数或天数');
            $table->enum('status',['0','1'])->commen('任务状态');
            $table->string('icon',255)->comment('任务图标');
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
        Schema::dropIfExists('mission');
    }
}
