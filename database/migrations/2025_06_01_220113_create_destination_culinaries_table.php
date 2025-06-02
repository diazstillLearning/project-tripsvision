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
        Schema::create('destination_culinaries', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_destinations');
        $table->unsignedBigInteger('id_culinaries');

        $table->foreign('id_destinations')->references('id_destinations')->on('destinations')->onDelete('cascade');
        $table->foreign('id_culinaries')->references('id_culinaries')->on('culinaries')->onDelete('cascade');

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_culinaries');
    }
};
