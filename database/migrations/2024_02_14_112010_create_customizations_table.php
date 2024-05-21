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
        Schema::create('customizations', function (Blueprint $table) {
            $table->id();
            $table->boolean('expanded_layout')->default(false);
            $table->string('card_type')->default('default');
            $table->string('header_type')->default('default');
            $table->string('side_type')->default('default');
            $table->string('footer_type')->default('default');
            $table->string('primary_color', 20)->default('#137000');
            $table->string('primary_border_color', 20)->default('#010409');
            $table->string('primary_text', 20)->default('#f5f5f5');
            $table->string('secondary_color', 20)->default('#010409');
            $table->string('background_color', 20)->default('#0D1117');
            $table->string('footer_color', 20)->default('#010409');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customizations');
    }
};
