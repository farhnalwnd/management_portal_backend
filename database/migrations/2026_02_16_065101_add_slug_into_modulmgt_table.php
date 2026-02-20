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
        Schema::table('modul_mgts', function (Blueprint $table) {
            $table->string('slug')->after('module_name')->nullable()->index();
            $table->string('api_secret')->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modul_mgts', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('api_secret');
        });
    }
};
