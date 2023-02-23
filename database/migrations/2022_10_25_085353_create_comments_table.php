<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->comment('评论者id');
            $table->unsignedBigInteger("article_id")->comment("文章id");
            $table->foreign("article_id")->references('id')->on('articles');
            $table->longText("content")->comment("评论内容");
            $table->unsignedBigInteger("parent_id")->nullable()->comment("父评论id");
//            $table->foreign("parent_id")->references('id')->on('comments');
            $table->enum('user_mark',["front","back"])->default("front")->comment("前端用户和后端用户标识");
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
