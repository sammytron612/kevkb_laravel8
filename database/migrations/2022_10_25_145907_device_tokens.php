<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeviceTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->string('token')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable();
            $table->string('platfrom_version')->nullable();
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
        //
    }
}
