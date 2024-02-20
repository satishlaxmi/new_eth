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
        Schema::create('emoji', function (Blueprint $table) {
            $table->id();
            $table->string('airtabel_id')->unique();
            $table->text('emoji_rating')->nullable();
            $table->text('collection')->nullable();
            $table->text('notes')->nullable();
            $table->json('sdgs')->nullable();
            $table->json('sdg_from_sdgs')->nullable();
            $table->json('esg')->nullable();
            $table->json('esg_impact')->nullable();
            $table->text('products')->nullable();
            $table->integer('count_Active_Products_CA_US')->nullable();
            $table->integer('count_Active_Products_US')->nullable();
            $table->integer('count_Active_Products_CA')->nullable();
            $table->json('parent_products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emoji');
    }
};
