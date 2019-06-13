<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_feed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ps_id')->unique();
            $table->string('title')->default('');
            $table->text('description')->default(null);
            $table->string('image_link')->default('');
            $table->string('link')->default('');
            $table->string('price')->default('');
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
        Schema::dropIfExists('fb_feed');
    }
}
