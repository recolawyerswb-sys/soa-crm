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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->default('lead');
            $table->string('phase')->nullable();
            $table->string('origin')->nullable();
            $table->string('status')->nullable();
            $table->integer('no_calls')->default(0);
            $table->dateTime('last_contact_at')->nullable();
            $table->foreignId('profile_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
