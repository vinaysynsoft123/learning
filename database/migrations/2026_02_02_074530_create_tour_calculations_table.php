<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_calculations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('hotel_category_id')->nullable();

            $table->date('travel_date')->nullable();

            $table->json('rooms'); // all room data
            $table->integer('total_pax');

            $table->unsignedBigInteger('vehicle_id')->nullable();

            $table->integer('markup')->default(0);
            $table->boolean('gst_applied')->default(false);

            $table->decimal('total_price', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_calculations');
    }
};
