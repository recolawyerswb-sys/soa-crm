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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('position')->default('A');
            $table->integer('no_calls')->default(0);
            $table->string('status')->default('1'); // 1 active, 0 inactive, 2 suspended
            $table->unsignedTinyInteger('day_off')->nullable();
            $table->time('checkin_hour')->nullable();
            $table->boolean('is_leader')->default(false);
            $table->foreignId('team_id');
            $table->foreignId('profile_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
