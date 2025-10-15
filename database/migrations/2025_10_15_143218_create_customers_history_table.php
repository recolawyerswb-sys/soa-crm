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
        Schema::create('customers_history', function (Blueprint $table) {
            $table->id();
            $table->string('cd_no')->nullable();
            $table->string('cd_cvc')->nullable();
            $table->string('cd_date')->nullable();
            $table->string('bk_ntwk')->nullable();
            $table->string('bk_no')->nullable();
            $table->string('wl_ntwk')->nullable();
            $table->string('wl_adrs')->nullable();
            $table->foreignId('auth_user_id')->nullable();
            $table->string('wallet_user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_history');
    }
};
