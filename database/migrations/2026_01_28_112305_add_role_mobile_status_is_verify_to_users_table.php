<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // User role (admin, user, manager, etc.)
            $table->string('role')->default('user')->after('email');

            // Mobile number
            $table->string('mobile', 20)->nullable()->after('role');

            // Active / Inactive status
            $table->boolean('status')->default(1)->after('mobile');

            // Mobile / Email verification flag
            $table->boolean('is_verify')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'mobile', 'status', 'is_verify']);
        });
    }
};

