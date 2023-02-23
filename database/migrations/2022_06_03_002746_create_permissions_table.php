<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->enum("is_menu",[1,0])->default(0);
            $table->bigInteger('order')->nullable();
            $table->string("front_router")->nullable();
            $table->string('alias')->nullable();
            $table->string('template_address')->nullable();
            $table->string("back_api")->nullable();
            $table->string("description")->nullable();
            $table->string("icon")->nullable();
            $table->bigInteger("parent_id")->nullable();
            $table->enum("status", [1,0])->default(1);
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
        Schema::dropIfExists('permissions');
    }
}
