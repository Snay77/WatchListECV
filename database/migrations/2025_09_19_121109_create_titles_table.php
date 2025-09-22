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
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_movie_tmdb')->nullable();
            $table->boolean('is_movie')->default(true);
            $table->string('name');
            $table->text('desc');
            $table->string('tagline')->nullable();
            $table->string('image')->nullable();
            $table->boolean('seen')->default(0);
            $table->date('release_date');
            $table->float('vote_average');
            $table->string('origin_country')->nullable();
            $table->time('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titles');
    }
};
