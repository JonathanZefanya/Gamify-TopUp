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
        Schema::create('top_up_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('top_up_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->text('image')->nullable();
            $table->string('image_driver')->nullable();
            $table->double('price')->nullable();
            $table->double('discount')->default(0);
            $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
            $table->boolean('status')->default(1)->comment("0=>off,1=>on");
            $table->boolean('is_offered')->default(0)->comment("0=>no,1=>yes");
            $table->integer('sort_by')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up_services');
    }
};
