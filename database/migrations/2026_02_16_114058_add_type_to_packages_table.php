<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
  public function up(): void
{
    Schema::table('packages', function (Blueprint $table) {
        if (!Schema::hasColumn('packages', 'destination_id')) {
            $table->unsignedBigInteger('destination_id')->nullable()->after('id');
        }
    });
}

public function down(): void
{
    Schema::table('packages', function (Blueprint $table) {
        if (Schema::hasColumn('packages', 'destination_id')) {
            $table->dropColumn('destination_id');
        }
    });
}

};

