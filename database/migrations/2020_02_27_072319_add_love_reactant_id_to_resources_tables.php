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
                $table->unsignedBigInteger('love_reactant_id')->nullable();

                $table
                    ->foreign('love_reactant_id')
                    ->references('id')
                    ->on('love_reactants');
            });
        }
    }

    public function down(): void
    {
        foreach(['comments', 'users', 'pets', 'photos', 'geofences'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['love_reactant_id']);
                $table->dropColumn('love_reactant_id');
            });
        }
    }
}
