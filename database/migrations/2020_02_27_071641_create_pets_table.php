<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique()->index();
            $table->point('location')->nullable(); // Latitude, Longitude
            $table->string('user_uuid')->index();
            $table->string('photo_uuid')->index();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('left_eye_color')->nullable();
            $table->string('right_eye_color')->nullable();
            $table->string('size')->nullable();
            $table->timestamp('born_at')->nullable();
            $table->string('api_token')->unique();
            $table->boolean('is_public')->default(true);
            $table->text('photo_url')->nullable();
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
        Schema::dropIfExists('pets');
    }
}
