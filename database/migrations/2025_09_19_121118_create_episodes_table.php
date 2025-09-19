<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id');
            $table->foreign('title_id')->references('id_title')->on('titles');
            $table->bigInteger('season');
            $table->bigInteger('episode_number');
            $table->string('name');
            $table->text('overview');
            $table->time('duration');
            $table->string('poster_path');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
