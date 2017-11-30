<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identity')->comment('配置标志');
            $table->string('name')->comment('配置名称');
            $table->decimal('rebate_ratio')->comment('比例');
            $table->softDeletes();
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
        Schema::dropIfExists('charge_config;');
    }
}
