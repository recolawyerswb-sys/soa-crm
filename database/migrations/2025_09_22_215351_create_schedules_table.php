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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // El día de la semana. Usaremos el estándar ISO-8601:
            // 1 = Lunes, 2 = Martes, ..., 7 = Domingo.
            $table->unsignedTinyInteger('day_of_week');

            $table->time('start_time'); // Ej: '08:00:00'
            $table->time('end_time');   // Ej: '16:00:00'

            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            // Evitar duplicados (un agente no puede tener dos horarios para el mismo día)
            $table->unique(['agent_id', 'day_of_week']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
