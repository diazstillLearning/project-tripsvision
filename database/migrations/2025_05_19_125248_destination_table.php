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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id('id_destinations');
            $table->string('name');
            $table->string('location');
            $table->decimal('price', 10, 2); // contoh: Rp 25.000,00'
            $table->string('price_range')->nullable(); // contoh: 'Rp 10.000 - Rp 50.000'
            $table->decimal('rating', 3, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('image_url')->nullable();
            $table->string('image_url2')->nullable();
            $table->string('image_url3')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
           # $table->unsignedBigInteger('id_locations');
            #$table->foreign('id_locations')->references('id_locations')->on('locations')->onDelete('cascade');

            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
