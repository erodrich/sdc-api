<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_full_name')->nullable();
            $table->string('image_full_public_id')->nullable();
            $table->string('image_full_url')->nullable();
            $table->string('image_pre_name')->nullable();
            $table->string('image_pre_public_id')->nullable();
            $table->string('image_pre_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('link_url')->nullable();
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
        Schema::dropIfExists('ads');
    }
}
