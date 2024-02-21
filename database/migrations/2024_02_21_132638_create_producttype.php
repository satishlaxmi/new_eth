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
        Schema::create('producttype', function (Blueprint $table) {
            $table->id();
            $table->string('airtabel_id')->unique();
            $table->text('level_3_collection')->nullable();
            $table->text('all_col_tag')->nullable();
            $table->json('product_type')->nullable();
            $table->json('catogery_filter')->nullable();
            $table->json('parent_products')->nullable();
            $table->json('header_catogery')->nullable();
            $table->json('collection')->nullable();
            $table->json('products')->nullable();
            $table->integer('good')->nullable();
            $table->integer('count_all')->nullable();
            $table->integer('count_ca')->nullable();
            $table->integer('count_us')->nullable();
            $table->integer('unionized')->nullable();
            $table->integer('better')->nullable();
            $table->integer('best')->nullable();
            $table->integer('women_owned')->nullable();
            $table->integer('social_causes')->nullable();
            $table->integer('biopic_own')->nullable();
            $table->integer('indigenous_owned')->nullable();
            $table->integer('refugee_owned')->nullable();
            $table->integer('b_corp')->nullable(); // Remove extra double quote
            $table->integer('environmental_causes')->nullable();
            $table->integer('organic')->nullable();
            $table->integer('biodegradable')->nullable(); // Remove extra double quote
            $table->integer('vegan')->nullable(); // Remove extra double quote
            $table->integer('made_can')->nullable();
            $table->integer('made_usa')->nullable();
            $table->integer('recycled')->nullable();
            $table->integer('LGBTQ2+_owned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producttype');
    }
};
