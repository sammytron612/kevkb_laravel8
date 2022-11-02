<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',500);
            $table->string('slug',500)->nullable();
            $table->longtext('body')->nullable();
            $table->integer('author');
            $table->string('kb')->nulllable();
            $table->integer('sectionid');
            $table->string('tags',500)->nullable();
            $table->string('attachments',500)->nullable();
            $table->integer('views')->default(0);
            $table->integer('attachCount')->default(0);
            $table->integer('notify_sent')->nullable();
            $table->smallInteger('bts')->default(0);
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
