<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('destination_id')->nullable();

            $table->longText('terms_conditions')->nullable();
            $table->longText('privacy_policy')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();

            // Foreign key (recommended)
            $table->foreign('destination_id')
                  ->references('id')
                  ->on('destinations')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
