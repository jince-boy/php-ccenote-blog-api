<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string("url")->nullable();
            $table->longText("profile")->nullable();
            $table->longText('token')->nullable();
            $table->longText('avatar')->nullable();
            $table->enum("status",[1,0])->default(1);
            $table->unsignedBigInteger("role_id")->nullable();
            $table->foreign("role_id")->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
