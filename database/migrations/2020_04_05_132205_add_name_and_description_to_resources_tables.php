<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndDescriptionToResourcesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(['geofences', 'users', 'pets', 'groups', 'devices', 'places'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('name');
                $table->longText('description')->nullable();
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
        foreach(['geofences', 'users', 'pets', 'groups', 'devices', 'places'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn([
                    'name',
                    'description'
                ]);
            });
        }
    }
}
