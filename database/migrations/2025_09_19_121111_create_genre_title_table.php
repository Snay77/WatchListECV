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

        // Schema::create('genre_title', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('genre_id');
        //     $table->foreign('genre_id')->references('id')->on('genres');
        //     $table->bigInteger('title_id');
        //     $table->foreign('title_id')->references('id_title')->on('titles');
        // });
        Schema::create('genre_title', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_title');
    }
};
