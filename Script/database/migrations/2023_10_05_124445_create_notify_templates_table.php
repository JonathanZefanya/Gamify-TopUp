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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->index();
            $table->string('name')->nullable();
            $table->string('email_from')->nullable();
            $table->string('template_key')->nullable();
            $table->text('subject')->nullable();
            $table->text('short_keys')->nullable();
            $table->text('email')->nullable();
            $table->text('sms')->nullable();
            $table->text('in_app')->nullable();
            $table->text('push')->nullable();
            $table->text('status')->nullable()->comment("	mail = 0(inactive), mail = 1(active), sms = 0(inactive), sms = 1(active), in_app = 0(inactive), in_app = 1(active), push = 0(inactive), push = 1(active)");
            $table->boolean('notify_for')->default(0)->comment("0 => user, 1 => admin");
            $table->string('lang_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
