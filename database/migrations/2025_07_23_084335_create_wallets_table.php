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
        Schema::create('wallets', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('coin_currency');
            $table->text('address');
            $table->string('network');

            $table->string('bank_network')->nullable();
            $table->string('account_number')->nullable();
            $table->string('card_number')->nullable();
            $table->string('cvc_code')->nullable();
            $table->string('exp_date')->nullable();

            $table->decimal('balance')->default(0.00);
            $table->decimal('total_withdrawn')->default(0.00);
            $table->decimal('total_deposit')->default(0.00);
            $table->string('last_movement_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
