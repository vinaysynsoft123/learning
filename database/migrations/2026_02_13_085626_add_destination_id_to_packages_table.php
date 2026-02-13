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
    Schema::table('packages', function (Blueprint $table) {
        $table->unsignedBigInteger('destination_id')->nullable()->after('id');
    });

    // FK alag se add karo
    Schema::table('packages', function (Blueprint $table) {
        $table->foreign('destination_id')
              ->references('id')
              ->on('destinations')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
};
