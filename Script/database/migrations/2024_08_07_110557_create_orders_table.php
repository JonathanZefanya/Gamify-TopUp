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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('payment_method_id')->nullable()->comment("-1=>for wallet payment");
            $table->double('amount')->default(0.00)->comment("total order amount");
            $table->text('info')->nullable()->comment("for dynamic information store");
            $table->boolean('payment_status')->default(0)->comment("0=>incomplete,1=>complete");
            $table->tinyInteger('status')->default(0)->comment("0=>initiate,1=>complete,2=>refund");
            $table->enum('order_for', ['topup', 'card']);
            $table->string('utr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
