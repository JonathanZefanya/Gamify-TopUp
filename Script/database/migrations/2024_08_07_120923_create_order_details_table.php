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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('order_id')->index();
            $table->morphs('detailable');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('image_driver')->nullable();
            $table->double('price')->default(0.00);
            $table->double('discount')->default(0.00);
            $table->integer('qty')->default(1)->comment("how many code order");
            $table->integer('stock_short')->default(0)->comment("how many code do not get buyer");
            $table->tinyInteger('status')->default(0)->comment("0=>initiate,1=>complete,2=>refund,3=>stock_short");
            $table->text('card_codes')->nullable()->comment("buyer card service code");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
