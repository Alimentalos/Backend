<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->point('location'); // Latitude, Longitude
            $table->bigInteger('user_id')->index()->unsigned();
            $table->bigInteger('comment_id')->index()->unsigned()->nullable();
            $table->string('uuid')->index()->unique();
            $table->string('ext');
            $table->string('photo_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('photoables', function (Blueprint $table) {
            $table->bigInteger('photo_id')->index()->unsigned();
            $table->morphs('photoable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
        Schema::dropIfExists('photoables');
    }
}
