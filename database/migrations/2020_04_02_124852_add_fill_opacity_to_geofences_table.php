<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOpacityToGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geofences', function (Blueprint $table) {
            $table->decimal('fill_opacity', 3, 2);
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
            $table->dropColumn('fill_opacity');
        });
    }
}
