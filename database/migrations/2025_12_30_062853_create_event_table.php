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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('city')->nullable();
            $table->string('capacity');
            $table->string('price');
            $table->string('image');
            $table->foreign('category')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('city')->references('id')->on('city')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
