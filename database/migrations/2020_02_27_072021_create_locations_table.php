<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('trackable');
            $table->json('device')->nullable();
            $table->string('uuid')->index()->nullable();
            $table->point('location'); // Latitude, Longitude
            $table->integer('accuracy')->index();
            $table->integer('altitude')->nullable();
            $table->decimal('speed', 10, 2)->nullable();
            $table->integer('heading')->nullable();
            $table->integer('odometer')->nullable();
            $table->string('event')->nullable();
            $table->string('activity_type')->nullable();
            $table->integer('activity_confidence')->nullable();
            $table->decimal('battery_level', 7, 2)->nullable();
            $table->boolean('battery_is_charging')->nullable();
            $table->boolean('is_moving')->nullable();
            $table->timestamp('generated_at')->useCurrent()->index();
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
        Schema::dropIfExists('locations');
    }
}
