<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidToResourcesTables extends Migration
{
    protected $resources = [
        'geofences',
        'users',
        'pets',
        'groups',
        'devices',
        'places',
        'accesses',
        'photos',
        'comments',
        'locations',
        'actions',
        'alerts',
        'coins',
        'operations'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->resources as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('uuid')->index();
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
        foreach($this->resources as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
}
