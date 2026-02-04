<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_calculations', function (Blueprint $table) {
            $table->string('unique_no', 255)
                  ->nullable()
                  ->unique()
                  ->after('id'); // adjust position if needed
        });
    }

    public function down(): void
    {
        Schema::table('tour_calculations', function (Blueprint $table) {
            $table->dropUnique('tour_calculations_unique_no_unique');
            $table->dropColumn('unique_no');
        });
    }
};
