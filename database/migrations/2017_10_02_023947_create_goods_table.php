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
            $table->integer('coin')->comment('所需金币');
            $table->integer('spec')->comment('娃娃规格');
            $table->integer('tag_id')->comment('娃娃标签');
            $table->enum('status',['0','1','-1'])->default('0')->comment('娃娃的状态');
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
