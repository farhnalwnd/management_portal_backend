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
        Schema::create('md_menu_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('md_menu_mgts')->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('md_approval_masters');
            $table->enum('action_type', ['activate', 'deactivate']);
            $table->dateTime('scheduled_at');
            $table->enum('status', ['pending', 'executed', 'failed', 'approval_stage', 'rejected'])->default('approval_stage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_menu_schedules');
    }
};
