<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserUuidToResourcesTable extends Migration
{
    protected $resources = [
        'geofences',
        'users',
        'pets',
        'groups',
        'devices',
        'places',
        'photos',
        'comments',
        'actions',
        'alerts',
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
                $table->string('user_uuid')->nullable()->index();
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
                $table->dropColumn('user_uuid');
            });
        }
    }
}
