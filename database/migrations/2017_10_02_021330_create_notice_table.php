<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id')->comment('公告id');
            $table->string('title',255)->omment('公告名称');
            $table->string('content',500)->comment('公告内容');
            $table->string('pic',255)->comment('对应图片');
            $table->enum('status',['1','-1'])->default('-1')->comment('公告状态');
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
        Schema::dropIfExists('notice');
    }
}
