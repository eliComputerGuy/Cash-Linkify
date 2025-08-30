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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // for verification
            $table->string('phone')->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'review', 'verified'])->default('pending');

            // Referral system
            $table->string('referral_code')->unique();
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null');

            // Registration phase tracking
            $table->enum('registration_stage', ['basic', 'kyc', 'complete'])->default('basic');

            // KYC details (Phase 2)
            $table->string('country')->nullable();
            $table->string('kyc_document_type')->nullable();
            $table->string('kyc_document_file')->nullable(); // for file upload
            $table->foreignId('level_id')->nullable()->constrained('levels')->onDelete('set null'); // investment level

            // Wallet and earnings
            $table->decimal('wallet_balance', 12, 2)->default(0);
            $table->decimal('total_earnings', 12, 2)->default(0);
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
