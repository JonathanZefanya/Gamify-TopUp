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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();$table->integer('notifyable_id')->nullable();
            $table->string('notifyable_type')->nullable();
            $table->text('template_email_key')->nullable();
            $table->text('template_sms_key')->nullable();
            $table->text('template_in_app_key')->nullable();
            $table->text('template_push_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
