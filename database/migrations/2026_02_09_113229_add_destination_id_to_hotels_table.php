<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::table('hotels', function (Blueprint $table) {
    if (!Schema::hasColumn('hotels', 'destination_id')) {
        $table->unsignedBigInteger('destination_id')->after('id');
    }
});

    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }
};
