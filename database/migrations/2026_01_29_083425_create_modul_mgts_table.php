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
        Schema::create('modul_mgts', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('module_description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('category');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('last_modified_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_mgts');
    }
};
