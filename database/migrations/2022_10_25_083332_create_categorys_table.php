<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique()->comment("分类名称");
            $table->string("description")->nullable();
            $table->enum("is_menu",[1,0])->default(0)->comment("是否为菜单");
            $table->bigInteger("order")->nullable();
            $table->string('icon')->nullable();
            $table->bigInteger("parent_id")->nullable();
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
        Schema::dropIfExists('categorys');
    }
}
