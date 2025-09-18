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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('id_movie_tmdb')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->boolean('seen')->default(0);
            $table->integer('vote_average')->nullable();
            $table->date('release_date')->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->integer('id_genre_tmdb')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('genre_movie', function (Blueprint $table) {
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });

        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            $table->integer('id_casts_tmdb')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('cast_movie', function (Blueprint $table) {
            $table->unsignedBigInteger('cast_id');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('cast_id')->references('id')->on('casts')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });

        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->integer('id_directors_tmdb')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('director_movie', function (Blueprint $table) {
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('director_id')->references('id')->on('directors')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
