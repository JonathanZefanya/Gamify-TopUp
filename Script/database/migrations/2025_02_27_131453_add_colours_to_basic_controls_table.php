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
        Schema::table('basic_controls', function (Blueprint $table) {
            $table->string('light_primary_color', 50)->nullable();
            $table->string('light_secondary_color', 50)->nullable();
            $table->string('dark_primary_color', 50)->nullable();
            $table->string('dark_secondary_color', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_controls', function (Blueprint $table) {
            //
        });
    }
};
