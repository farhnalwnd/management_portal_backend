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
        Schema::create('content_mgts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title')->index();
            $table->foreignId('modul_id')->constrained('modul_mgts');
            $table->string('version');
            $table->boolean('status')->default(false);
            $table->string('repo');
            $table->foreignId('created_by')->constrained('users')->nullable();
            $table->foreignId('last_modified_by')->constrained('users')->nullable();
            $table->foreignId('published_by')->constrained('users')->nullable();
            $table->date('published_date')->nullable();
            $table->foreignId('approver_id')->constrained('users')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_mgts');
    }
};
