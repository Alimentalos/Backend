<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('fill_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('user_color')->nullable();
            $table->string('administrator_color')->nullable();
            $table->string('owner_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn([
                'color',
                'background_color',
                'border_color',
                'fill_color',
                'text_color',
                'user_color',
                'administrator_color',
                'owner_color',
            ]);
        });
    }
}
