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
            foreach (['photo_url', 'marker', 'color', 'border_color', 'background_color', 'text_color', 'fill_color', 'tag_color', 'flag_color'] as $item) {
                $table->string($item)->nullable();
            }
            $table->string('user_uuid')->index();
            $table->string('photo_uuid')->index()->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->polygon('shape')->nullable();
            $table->boolean('is_public')->default(true);
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
