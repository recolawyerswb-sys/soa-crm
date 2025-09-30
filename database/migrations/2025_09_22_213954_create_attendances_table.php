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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->char('att_status'); # super puntual (+-15 antes), b: puntual, c: tardio (+-15 despues)
            $table->text('notes')->nullable();
            $table->date('att_date');
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->unique(['agent_id', 'att_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
