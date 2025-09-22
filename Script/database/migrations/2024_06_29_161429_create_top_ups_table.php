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
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('region')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(1)->comment("0=>inactive,1=>active");
            $table->boolean('is_trending')->default(0)->comment("0=>no,1=>yes");
            $table->boolean('instant_delivery')->default(1)->comment("0=>inactive,1=>active");
            $table->text('image')->nullable();
            $table->longText('order_information')->nullable();
            $table->longText('description')->nullable();
            $table->longText('guide')->nullable();
            $table->integer('sort_by')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_ups');
    }
};
