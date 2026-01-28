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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();

        $table->string('name'); // Sedan, SUV, Tempo Traveller
        $table->integer('capacity'); // Total pax
        $table->decimal('price_per_day', 10, 2);
        $table->decimal('other', 10, 2);
        $table->boolean('status')->default(1);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
