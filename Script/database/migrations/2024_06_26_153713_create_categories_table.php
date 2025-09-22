<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('image')->nullable();
            $table->string('driver')->nullable();
            $table->enum('type', ['top_up', 'card', 'game'])->default('card');
            $table->boolean('status')->default(1)->comment('0=>inactive,1=>active');
            $table->integer('sort_by')->default(1);
            $table->integer('active_children')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
