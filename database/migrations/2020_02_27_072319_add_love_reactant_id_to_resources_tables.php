<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddLoveReactantIdToResourcesTables extends Migration
{
    public function up(): void
    {
        foreach(['comments', 'users', 'pets', 'photos', 'geofences'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('love_reactant_uuid')->nullable();

                $table
                    ->foreign('love_reactant_uuid')
                    ->references('uuid')
                    ->on('love_reactants');
            });
        }
    }

    public function down(): void
    {
        foreach(['comments', 'users', 'pets', 'photos', 'geofences'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['love_reactant_uuid']);
                $table->dropColumn('love_reactant_uuid');
            });
        }
    }
}
