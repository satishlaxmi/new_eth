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
        Schema::create('colour', function (Blueprint $table) {
            $table->id();
            $table->string('airtabel_id')->unique();
            $table->text('colour_categories')->nullable();
            $table->json('color_swatch')->nullable();
            $table->string('color_swatch_id')->unique();
            $table->text('image')->nullable();
            $table->json('colour_catogery')->nullable();
            $table->json('parent_products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colours');
    }
};
