<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('分享标题');
            $table->string('desc')->comment('分享描述');
            $table->string('links')->comment('分享链接');
            $table->string('img_url')->comment('分享的图标');
            $table->enum('status',['-1','1'])->default('-1')->commnet('是否启用');
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
        Schema::dropIfExists('share_data');
    }
}
