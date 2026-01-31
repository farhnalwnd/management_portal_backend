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
            $table->string('status');
            $table->string('repo');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('last_modified_by')->constrained('users');
            $table->foreignId('published_by')->constrained('users');
            $table->date('published_date');
            $table->foreignId('approver_id')->constrained('users');
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
