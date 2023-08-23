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
        Schema::create('rent_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->index();
            $table->integer('minimum_tenancy')->nullable();
            $table->double('price_weekly', 8, 2)->nullable();
            $table->double('price_monthly', 8, 2)->nullable();
            $table->double('deposit', 8, 2)->nullable();
            $table->boolean('pets_allowed')->default(0);
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_listings');
    }
};
