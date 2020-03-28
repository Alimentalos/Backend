<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geofences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique()->index();
            $table->string('user_uuid')->index();
            $table->string('photo_uuid')->index()->nullable();
            $table->string('marker')->nullable();
            $table->string('color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('fill_color')->nullable();
            $table->string('tag_color')->nullable();
            $table->string('flag_color')->nullable();
            $table->string('administrators_color')->nullable();
            $table->string('owner_color')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->polygon('shape')->nullable();
            $table->boolean('is_public')->default(true);
            $table->text('photo_url')->nullable();
            $table->timestamps();
        });

        Schema::create('geofenceables', function (Blueprint $table) {
            $table->string('geofence_uuid')->index();
            $table->uuidMorphs('geofenceable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geofences');
        Schema::dropIfExists('geofenceables');
    }
}
