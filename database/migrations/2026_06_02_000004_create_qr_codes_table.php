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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('merchant_code')->nullable();
            $table->foreignId('user_id')->constrained('onopay_users')->onDelete('cascade');
            $table->decimal('amount', 15, 2)->nullable(); // Fixed amount or null for dynamic
            $table->string('description')->nullable();
            $table->text('qr_data');
            $table->enum('status', ['active', 'expired', 'used', 'cancelled'])->default('active');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
