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
            $table->string('action_type'); // activate, deactivate
            $table->dateTime('scheduled_at');
            $table->string('status')->default('pending'); // pending, executed, failed
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
