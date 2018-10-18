<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentListeners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_listeners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('listened')->comment("被监听的组件名");
            $table->string('handle')->comment("监听到组件后要执行的组件名");
            $table->string('position')->default('behind')->comment("监听的位置，默认时在组件执行后执行");
            $table->integer('async')->default(0)->comment("同步执行还是异步执行，默认是同步执行");
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
        Schema::dropIfExists('component_listeners');
    }
}
