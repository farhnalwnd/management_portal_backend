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
        Schema::create('approval_mgts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approver_id')->constrained('users');
            $table->foreignId('content_id')->constrained('content_mgts');
            $table->string('approval_level')->nullable();
            $table->string('token')->nullable();
            $table->string('comments')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_mgts');
    }
};
