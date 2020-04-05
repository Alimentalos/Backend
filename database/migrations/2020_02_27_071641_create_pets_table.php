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
            $table->string('user_uuid')->index();
            $table->string('photo_uuid')->index();
            $table->string('photo_url')->nullable();
            $table->string('name');
            $table->string('size')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('born_at')->nullable();
            $table->boolean('is_public')->default(true);
            $table->point('location')->nullable();
            $table->string('api_token')->unique();
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
