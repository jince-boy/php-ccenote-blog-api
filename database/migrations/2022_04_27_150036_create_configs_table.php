<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable()->comment('网站标题');
            $table->string("description")->nullable()->comment('网站描述');
            $table->string("keywords")->nullable()->comment('网站关键字');
            $table->longText("logo")->nullable()->comment('网站logo');
            $table->enum("is_register", [1,0])->default(1)->comment('开启注册');
            $table->enum("site_status",[1,0])->default(1)->comment('网站状态');
            $table->string('close_reason')->nullable()->comment('关闭原因');
            $table->string("copyright")->nullable()->comment('版权');
            $table->string("record")->nullable()->comment("备案");
            $table->string("edition")->nullable()->comment('版本');
            $table->integer("front_page_num")->default(10);
            $table->integer("back_page_num")->default(10);
            $table->string('contact')->nullable()->comment('联系方式');
            $table->string('notice')->nullable()->comment('网站公告');
            $table->enum('grey',[1,0])->default(0)->comment('网站变灰');
            $table->timestamp("running_time")->nullable()->comment('运行时间');
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
        Schema::dropIfExists('config');
    }
}
