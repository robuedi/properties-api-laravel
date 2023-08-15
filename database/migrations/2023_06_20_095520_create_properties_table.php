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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('owner_id')->index();
            $table->unsignedBigInteger('property_type_id')->index();
            $table->unsignedBigInteger('address_id')->index()->nullable();
            $table->unsignedBigInteger('listing_type_id')->index();
            $table->text('description');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->boolean('is_public')->default('0');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('property_type_id')->references('id')->on('property_types');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('listing_type_id')->references('id')->on('listing_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
