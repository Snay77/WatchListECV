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

        // Schema::create('user_title', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('title_id');
        //     $table->foreign('title_id')->references('id_title')->on('titles');
        //     $table->bigInteger('user_id');
        //     $table->foreign('user_id')->references('id')->on('user');
        //     $table->boolean('watched')->default(false);
        //     $table->boolean('liked')->default(false);
        // });
        Schema::create('user_title', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('watched')->default(false);
            $table->boolean('liked')->default(false);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_title');
    }
};
