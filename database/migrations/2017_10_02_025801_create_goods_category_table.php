<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_category', function (Blueprint $table) {
            $table->increments('id')->comment('类别id');
            $table->string('cate_name',255)->comment('类别名称');
            $table->string('pic',255)->comment('对应图片');
            $table->float('win_rate',6,5)->comment('赢得比例');
            $table->integer('tag_id')->comment('娃娃标签（新品、人气等）');
            $table->integer('spec')->comment('娃娃规格');
            $table->integer('coin')->comment('所需金币');
            $table->enum('status',['-1','1'])->default('-1')->comment('娃娃机上下架状态');
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
        Schema::dropIfExists('goods_category');
    }
}
