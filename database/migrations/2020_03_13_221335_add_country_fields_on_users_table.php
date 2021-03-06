<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryFieldsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('country')->nullable();
            $table->string('country_name')->nullable();
            $table->unsignedInteger('region')->nullable();
            $table->string('region_name')->nullable();
            $table->unsignedInteger('city')->nullable();
            $table->string('city_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['country', 'region', 'city', 'country_name', 'region_name', 'city_name']);
        });
    }
}
