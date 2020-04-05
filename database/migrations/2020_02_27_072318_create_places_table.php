<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->string('uuid')->index()->nullable();
            $table->point('location'); // Latitude, Longitude
            $table->string('user_uuid')->index();
            $table->string('marker')->nullable();
            $table->string('marker_color')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_public')->default(true);
            $table->string('name');
            $table->longText('description');
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
        Schema::dropIfExists('places');
    }
}
