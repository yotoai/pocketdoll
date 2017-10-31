<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mission', function (Blueprint $table) {
            $table->increments('id')->comment('关联表id');
            $table->string('user_id')->comment('用户id');
            $table->integer('mission_id')->comment('任务id');
            $table->enum('status',['-1','1'])->default('-1')->comment('完成状态');
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
        Schema::dropIfExists('user_mission');
    }
}
