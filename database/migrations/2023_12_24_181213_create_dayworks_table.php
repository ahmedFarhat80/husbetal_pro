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
        Schema::create('dayworks', function (Blueprint $table) {
            $table->id();
            $table->boolean('day1', 0)->default(0);
            $table->boolean('day3', 0)->default(0);
            $table->boolean('day2', 0)->default(0);
            $table->boolean('day4', 0)->default(0);
            $table->boolean('day5', 0)->default(0);
            $table->boolean('day6', 0)->default(0);
            $table->boolean('day7', 0)->default(0);
            $table->integer('time')->default(30);
            
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dayworks');
    }
};
