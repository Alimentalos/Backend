<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoableColumnToResourcesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(['geofences', 'users', 'pets', 'groups', 'places', 'alerts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('photo_uuid')->index()->nullable();
                $table->string('photo_url')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(['geofences', 'users', 'pets', 'groups', 'places', 'alerts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn([
                    'photo_uuid',
                    'photo_url'
                ]);
            });
        }
    }
}
