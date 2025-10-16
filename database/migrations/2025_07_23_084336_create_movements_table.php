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
        Schema::create('movements', function (Blueprint $table) {
            $table->string('id', 12)->primary();
            $table->decimal('amount');
            $table->string('type');
            $table->string('status')->default('2'); // 1: Aprobado, 2: Pendiente, 0: Rechazado
            $table->text('note')->nullable();
            $table->string('wallet_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
