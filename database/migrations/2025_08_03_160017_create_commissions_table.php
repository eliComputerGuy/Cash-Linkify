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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficiary_user_id'); // who gets paid
            $table->unsignedBigInteger('source_user_id');      // who triggered it (the earner)
            $table->unsignedBigInteger('task_log_id')->nullable();         // anchor to the earning event
            $table->unsignedBigInteger('video_id')->nullable();            // helpful denorm
            $table->decimal('amount', 12, 2);
            $table->unsignedTinyInteger('level');              // 1,2,3
            $table->string('type');                            // e.g., 'video_task'
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('beneficiary_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('source_user_id')->references('id')->on('users')->cascadeOnDelete();
            // Temporarily comment out the foreign key constraint until task_logs table exists.
            // $table->foreign('task_log_id')->references('id')->on('task_logs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
