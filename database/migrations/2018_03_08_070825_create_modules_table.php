<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("模块名，可中文可英文");
            $table->string("dir")->comment("模块路径名，必须英文，不可以用特殊符号");
            $table->text("description")->comment("模型描述");
            $table->integer("model_id")->default(0)->comment("所属模型id，默认是0");
            $table->integer("module_id")->default(0)->comment("上级模块id，默认是0，即顶级模块");
            $table->string("status")->default("使用中")->comment("当前模块的状态");
            $table->text("template_map")->comment("当前模块的模版映射");
            $table->text("config")->comment("当前模块继承自模型的配置项");
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
        Schema::dropIfExists('modules');
    }
}
