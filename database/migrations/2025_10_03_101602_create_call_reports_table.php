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
        Schema::create('call_reports', function (Blueprint $table) {
            $table->id();
            $table->string('call_sid')->unique()->comment('ID de llamadas de Twilio');
            $table->string('call_status')->nullable();
            $table->text('call_notes')->nullable();
            $table->string('customer_phase');
            $table->string('customer_status');
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_reports');
    }
};
