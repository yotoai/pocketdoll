<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_tags_cate', function (Blueprint $table) {
            $table->increments('id')->comment('标签id');
            $table->string('tag_name',255)->comment('标签名称');
            $table->string('tag_icon',255)->comment('标签图片');
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
        Schema::dropIfExists('goods_tags_cate');
    }
}
