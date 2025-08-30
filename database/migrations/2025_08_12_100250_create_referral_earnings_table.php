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
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // who earned the commission
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade'); // who triggered the earning
            $table->foreignId('level_id')->nullable()->constrained('levels')->onDelete('set null'); // membership package
            $table->decimal('amount', 12, 2);
            $table->unsignedTinyInteger('referral_level'); // 1, 2, or 3
            $table->string('description')->nullable(); // e.g., "15% from User #5 subscription"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');
    }
};
