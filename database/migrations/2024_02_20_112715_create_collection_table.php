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
        Schema::create('collection', function (Blueprint $table) {
            $table->id();
            $table->string('airtabel_id')->unique();
            $table->text('level_3_collection')->nullable();
            $table->json('product_type')->nullable();
            $table->json('catogery')->nullable();
            $table->json('products')->nullable();
            $table->number('good')->nullable();
            $table->number('better')->nullable();
            $table->number('best')->nullable();
            $table->number('women_owned')->nullable();
            $table->number('socail_causes')->nullable();
            $table->number('biopic_own')->nullable();
            $table->number('indigenous_owned')->nullable();
            $table->number('refugee_owned')->nullable();
            $table->number('b_corp"')->nullable();
            $table->number('environmental_causes')->nullable();
            $table->number('organic')->nullable();
            $table->number('biodegradable"')->nullable();
            $table->number('vegan"')->nullable();
            $table->number('made_can')->nullable();
            $table->number('made_usa')->nullable();
            $table->number('recycled')->nullable();
            $table->number('LGBTQ2+_owned')->nullable();
            $table->json('parent_products')->nullable();
            $table->json('product_type_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection');
    }
};
