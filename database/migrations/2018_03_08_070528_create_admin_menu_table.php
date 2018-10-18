<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('菜单名');
            $table->string('name_en')->comment('菜单英文名，用于构建api');
            $table->string('authority_name')->comment('权限名，用于与权限表进行关联');
            $table->string('type')->default('content')->comment('菜单类型，默认是内容管理下的菜单');
            $table->string('belong_site')->default('default')->comment('所属站点，默认是default，');
            $table->string('icon')->default('folder-o')->comment('图标');
            $table->integer('order_id')->default(0)->comment("菜单排序，用来给后台菜单的显示界面排序");
            $table->integer('pid')->comment('上级菜单id');
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
        Schema::dropIfExists('admin_menus');
    }
}
