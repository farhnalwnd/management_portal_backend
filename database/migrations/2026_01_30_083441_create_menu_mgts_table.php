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
        Schema::create('menu_mgts', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->foreignId('module_id')->constrained('modul_mgts');
            $table->foreignId('content_id')->constrained('content_mgts');
            $table->integer('display_order')->unique();
            $table->integer('menu_level')->unique();
            $table->boolean('is_active')->default(true);
            $table->index(['menu_name', 'module_id', 'content_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_mgts');
    }
};
