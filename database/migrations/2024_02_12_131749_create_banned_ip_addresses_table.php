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
        Schema::create('banned_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique(); // تخزين عنوان IP
            $table->timestamp('ban_expiry')->nullable(); // تخزين تاريخ انتهاء الحظر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_ip_addresses');
    }
};
