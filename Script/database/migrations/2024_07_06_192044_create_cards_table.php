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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('region')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_trending')->default(0)->comment("0=>no,1=>yes");
            $table->boolean('instant_delivery')->default(1);
            $table->text('image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('guide')->nullable();
            $table->integer('sort_by')->nullable();
            $table->integer('sell_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
