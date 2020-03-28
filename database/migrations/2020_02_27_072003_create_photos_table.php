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
            $table->string('uuid')->index()->unique();
            $table->string('user_uuid')->index();
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('ext');
            $table->string('photo_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('photoables', function (Blueprint $table) {
            $table->string('photo_uuid')->index();
            $table->uuidMorphs('photoable');
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
