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
        Schema::create('hotels', function (Blueprint $table) {
        $table->id();
        $table->string('name');              // Taj Palace, Radisson
        $table->string('city')->nullable();
        $table->string('state')->nullable();

        $table->foreignId('hotel_category_id')->constrained();
        $table->boolean('status')->default(1);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
