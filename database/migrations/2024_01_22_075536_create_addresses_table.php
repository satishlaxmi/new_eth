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
        Schema::create('addresses', function (Blueprint $table) {
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();
                $table->string('single_address');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone_number');
                $table->string('email');
                $table->string('company_name');
                $table->string('address');
                $table->string('appartment');
                $table->string('street');
                $table->string('city');
                $table->string('state');
                $table->string('postal_code');
                $table->string('country');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
