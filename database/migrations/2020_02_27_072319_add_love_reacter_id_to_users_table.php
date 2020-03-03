<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AddLoveReacterIdToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('love_reacter_id')->nullable();

            $table
                ->foreign('love_reacter_id')
                ->references('id')
                ->on('love_reacters');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['love_reacter_id']);
            $table->dropColumn('love_reacter_id');
        });
    }
}
