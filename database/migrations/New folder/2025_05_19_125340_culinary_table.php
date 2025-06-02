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
        Schema::create('culinaries', function (Blueprint $table) {
            $table->id('id_culinaries');
            $table->unsignedBigInteger('id_destinations');
            $table->string('name');
            $table->string('location');
            $table->enum('price_range', ['low', 'medium', 'high']);
            $table->decimal('rating', 3, 2);
            $table->string('cuisine_type');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culinaries');
    }
};
