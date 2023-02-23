<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title")->comment("标题");
            $table->longText("content")->comment("内容");
            $table->string("cover")->comment('封面图片');
            $table->timestamp("date")->default("2023.01.01 12:00:00")->comment("文章发布日期");
            $table->enum("status",[1,0])->default(1);
            $table->enum("comment_status",[1,0])->default(1)->comment("是否开启评论");
            $table->enum("key",[1,0])->default(0)->comment("文章是否加密");
            $table->string("password")->nullable()->comment("文章密码");
            $table->enum("is_top",[1,0])->default(0)->comment("是否置顶");
            $table->bigInteger("page_views")->nullable()->comment("浏览量");
            $table->longText("keywords")->nullable()->comment("关键字");
            $table->longText("description")->nullable()->comment("摘要");
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->foreign("admin_id")->references("id")->on("admins");
            $table->unsignedBigInteger("category_id")->nullable();
            $table->foreign("category_id")->references("id")->on("categorys");
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
        Schema::dropIfExists('articles');
    }
}
