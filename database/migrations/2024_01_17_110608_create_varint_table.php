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
        Schema::create('varaiant', function (Blueprint $table) {
            $table->id();
            $table->string('air_id_varaint');
            $table->string('variant_label');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('parent_product')->nullable();
            $table->string('decoration_type');
            $table->string('color');
            $table->string('supp_inv_status');
            $table->dateTime('back_until')->nullable();
            $table->string('im_ca');
            $table->string('im_us');
            $table->string('link_im_ca');
            $table->string('link_im_us');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varint');
    }
};
