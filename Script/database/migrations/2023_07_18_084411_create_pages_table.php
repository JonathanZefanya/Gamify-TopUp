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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('template_name', 191)->nullable();
            $table->string('custom_link')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('meta_image_driver', 50)->nullable();
            $table->string('breadcrumb_image')->nullable();
            $table->string('breadcrumb_image_driver', 50)->nullable();
            $table->tinyInteger('breadcrumb_status')->default(1)->comment('0 => inactive, 1 => active');
            $table->tinyInteger('status')->default(1)->comment('0 => unpublish, 1 => publish');
            $table->tinyInteger('type')->default(0)->comment('0 => admin create, 1 => developer create, 2 => create for menus');
            $table->tinyInteger('is_breadcrumb_img')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
