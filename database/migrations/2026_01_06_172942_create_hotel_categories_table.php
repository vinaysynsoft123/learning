<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('hotel_categories', function (Blueprint $table) {
        $table->id();

        $table->string('name'); // 3 Star, 4 Star, 5 Star
        $table->decimal('price_multiplier', 5, 2)->default(1.00);
        $table->boolean('status')->default(1);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_categories');
    }
};
