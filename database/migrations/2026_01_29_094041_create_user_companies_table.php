<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 🏢 Company Details
            $table->string('company_name');
            $table->string('email')->nullable();
            $table->string('mobile', 15)->nullable();

            // 📍 Address
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();           
            $table->string('pincode', 10)->nullable();

            // 🧾 Tax Details
            $table->string('gst_number', 20)->nullable()->unique();
            $table->string('pan_number', 20)->nullable()->unique();

            // 🖼 Logo
            $table->string('logo')->nullable();

            // ⚙️ Status
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_companies');
    }
};
