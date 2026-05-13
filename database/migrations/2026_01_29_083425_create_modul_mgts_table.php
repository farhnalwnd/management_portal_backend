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
        Schema::create('md_modul_mgts', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('slug')->unique()->index();
            $table->string('api_secret')->nullable();
            $table->string('module_description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('category')->constrained('md_module_categories');
            $table->foreignId('created_by')->constrained('md_users');
            $table->foreignId('last_modified_by')->constrained('md_users');
            $table->softDeletes();
            $table->index(['module_name', 'is_active', 'category', 'created_by']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_modul_mgts');
    }
};
