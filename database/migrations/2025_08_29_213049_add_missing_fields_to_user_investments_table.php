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
        Schema::table('user_investments', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('amount');
            $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending')->after('payment_proof');
            $table->decimal('daily_profit', 12, 2)->default(0)->after('payment_status');
            $table->decimal('total_profit', 12, 2)->default(0)->after('daily_profit');
            $table->text('admin_notes')->nullable()->after('total_profit');
            $table->timestamp('verified_at')->nullable()->after('admin_notes');
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_investments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['payment_proof', 'payment_status', 'daily_profit', 'total_profit', 'admin_notes', 'verified_at', 'verified_by']);
        });
    }
};
