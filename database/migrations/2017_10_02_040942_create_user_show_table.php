<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_show', function (Blueprint $table) {
            $table->increments('id')->comment('记录id');
            $table->integer('user_id')->comment('用户id');
            $table->string('contents',500)->comment('用户发言');
            $table->string('pic',255)->comment('用户美照');
            $table->enum('status',['0','1'])->default('0')->comment('审核状态');
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
        Schema::dropIfExists('user_show');
    }
}
