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
        Schema::create('stays', function (Blueprint $table) {
            $table->id('id_stays');
            $table->string('name');
            #$table->unsignedBigInteger('id_locations');
            #$table->foreign('id_locations')->references('id_locations')->on('locations')->onDelete('cascade');
            $table->string('location');
            $table->decimal('price', 10, 2); // contoh: Rp 25.000,00
            $table->decimal('rating', 3, 2)->nullable();
            $table->text('amenities')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('image_url2')->nullable();
            $table->string('image_url3')->nullable();
            $table->unsignedBigInteger('id_destinations');
            $table->foreign('id_destinations')->references('id_destinations')->on('destinations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stays');
    }
};
