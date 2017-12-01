<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalkExpressionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_expression', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dollmachine_id')->comment('娃娃机id');
            $table->string('talk_doll',300)->nullable()->comment('娃娃对话');
            $table->string('small_expression',500)->nullable()->comment('小表情');
            $table->tinyInteger('type')->comment('出现的情况');
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
        Schema::dropIfExists('talk_expression');
    }
}
