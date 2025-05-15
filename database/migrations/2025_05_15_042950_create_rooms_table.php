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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
        $table->string('room_number')->unique();
        $table->string('type'); // single, double, deluxe, etc.
        $table->decimal('price_per_night', 8, 2);
        $table->text('description')->nullable();
        $table->string('image')->nullable(); // store image filename/path
        $table->enum('status', ['available', 'unavailable'])->default('available');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
