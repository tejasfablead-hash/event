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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer')->nullable();
            $table->unsignedBigInteger('event')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('qty');
            $table->enum('status', ['cancelled', 'confirmed', 'pending'])->default('pending');
            $table->foreign('customer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event')->references('id')->on('event')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
