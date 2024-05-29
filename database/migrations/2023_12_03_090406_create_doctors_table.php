<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date')->nullable(); // تاريخ بدء العمل
            $table->string('start_time')->nullable(); // ساعة بدء العمل
            $table->string('national_id')->unique(); // الرقم المدني
            $table->string('phone_number')->unique(); // رقم الهاتف
            $table->string('password')->default(Hash::make('password'));
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('code')->nullable();
            $table->string('last_verification_sent_at')->nullable(); // تاريخ بدء العمل
            $table->boolean('isactive', 1)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
