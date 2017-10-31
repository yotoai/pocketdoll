<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id')->comment('娃娃id');
            $table->integer('goods_cate_id')->comment('娃娃种类');
            $table->string('name',255)->comment('娃娃名称');
            $table->string('pic',255)->comment('娃娃图片');
            $table->string('sc_pic')->comment('素材图片');
            $table->integer('width')->comment('娃娃宽度');
            $table->integer('height')->comment('娃娃高度');
            $table->enum('status',['1','-1'])->default('1')->comment('娃娃的状态');
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
        Schema::dropIfExists('goods');
    }
}
