<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique()->index();
            $table->string('user_uuid')->index();
            $table->string('photo_uuid')->index();
            $table->string('color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('fill_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->boolean('is_public')->default(true);
            $table->text('photo_url')->nullable();
            $table->timestamps();
        });

        Schema::create('groupables', function (Blueprint $table) {
            $table->string('group_uuid')->index();
            $table->string('sender_uuid')->index()->nullable();
            $table->string('status')->default(Alimentalos\Relationships\Models\Group::PENDING_STATUS)->index();
            $table->boolean('is_admin')->default(false)->index();
            $table->uuidMorphs('groupable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('groupables');
    }
}
