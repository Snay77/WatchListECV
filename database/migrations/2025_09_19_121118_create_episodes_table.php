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

        // Schema::create('episodes', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('title_id');
        //     $table->foreign('title_id')->references('id_title')->on('titles');
        //     $table->bigInteger('season');
        //     $table->bigInteger('episode_number');
        //     $table->string('name');
        //     $table->text('overview');
        //     $table->time('duration');
        //     $table->string('poster_path');
        // });

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->bigInteger('season')->nullable();
            $table->bigInteger('episode_number')->nullable();
            $table->string('name');
            $table->text('overview')->nullable();
            $table->time('duration')->nullable();
            $table->boolean('seen')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
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
