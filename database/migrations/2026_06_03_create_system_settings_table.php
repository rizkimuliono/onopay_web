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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        \DB::table('system_settings')->insert([
            [
                'key' => 'topup_verification_enabled',
                'value' => '0', // 0 = off (auto approve), 1 = on (needs admin approval)
                'description' => 'Enable/disable topup verification by admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
