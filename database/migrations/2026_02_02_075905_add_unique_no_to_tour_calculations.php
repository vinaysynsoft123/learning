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
        Schema::table('tour_calculations', function (Blueprint $table) {
          $table->string('unique_no')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_calculations', function (Blueprint $table) {
             $table->dropUnique(['unique_no']);
            $table->dropColumn('unique_no');
        });
    }
};
