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
        Schema::create('bulkestimates', function (Blueprint $table) {
            $table->id();
            $table->json('productDetails')->required();
            $table->json('singleAddress')->required();
            $table->json('others')->required();
            $table->tinyInteger('isCompleted')->default(0)->required();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulkestimate');
    }
};
