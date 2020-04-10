<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsToGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geofences', function (Blueprint $table) {
            // Display
            $table->string('color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('tag_color')->nullable();

            // Profile
            $table->string('background_color')->nullable();

            // Shape
            $table->string('border_color')->nullable();
            $table->string('fill_color')->nullable();
            $table->decimal('fill_opacity', 3, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geofences', function (Blueprint $table) {
            $table->dropColumn([
                'color',
                'border_color',
                'background_color',
                'text_color',
                'fill_color',
                'tag_color',
                'fill_opacity'
            ]);
        });
    }
}
