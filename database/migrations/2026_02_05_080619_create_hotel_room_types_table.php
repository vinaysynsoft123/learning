<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation with hotel
            $table->foreignId('hotel_id')
                  ->constrained('hotels')
                  ->cascadeOnDelete();

            // 🛏 Room info
            $table->string('name'); // Deluxe, Super Deluxe

            // 👥 Occupancy rules
            $table->unsignedTinyInteger('base_pax')->default(2);
            $table->unsignedTinyInteger('max_pax')->default(3);

            // 💰 Default pricing (per night)
            $table->decimal('base_price', 10, 2);
            $table->decimal('extra_adult_price', 10, 2)->default(0);
            $table->decimal('child_with_bed_price', 10, 2)->default(0);
            $table->decimal('child_no_bed_price', 10, 2)->default(0);
            $table->decimal('infant_price', 10, 2)->default(0);

            // 🌦️ SEASON MANAGEMENT (SIMPLE)
            $table->date('season_start')->nullable(); // null = normal price
            $table->date('season_end')->nullable();

            $table->decimal('season_base_price', 10, 2)->nullable();
            $table->decimal('season_extra_adult_price', 10, 2)->nullable();
            $table->decimal('season_child_with_bed_price', 10, 2)->nullable();
            $table->decimal('season_child_no_bed_price', 10, 2)->nullable();

            // ⚙️ Status
            $table->boolean('status')->default(1);

            $table->timestamps();

            // ⚠️ Prevent duplicate same-season rows
            $table->index(['hotel_id', 'name', 'season_start', 'season_end']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_room_types');
    }
};
