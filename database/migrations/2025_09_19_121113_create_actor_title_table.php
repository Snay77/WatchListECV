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

        // Schema::create('actor_title', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('actor_id');
        //     $table->foreign('actor_id')->references('id')->on('actors');
        //     $table->bigInteger('title_id');
        //     $table->foreign('title_id')->references('id_title')->on('titles');
        //     $table->string('character');
        // });
        Schema::create('actor_title', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained('actors')->cascadeOnDelete();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->string('character')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_title');
    }
};
