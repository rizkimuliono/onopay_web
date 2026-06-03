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
        Schema::create('balance_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('onopay_users')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('set null')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['add', 'subtract'])->default('add');
            $table->string('reason')->nullable();          // Admin can provide reason
            $table->text('notes')->nullable();
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_adjustments');
    }
};
