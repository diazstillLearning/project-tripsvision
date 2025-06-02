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
        Schema::create('culinary_travel_package', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('travel_package_id');
        $table->unsignedBigInteger('id_culinaries');

        $table->foreign('travel_package_id')->references('id')->on('travel_packages')->onDelete('cascade');
        $table->foreign('id_culinaries')->references('id_culinaries')->on('culinaries')->onDelete('cascade');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culinaries_travel_package');
    }
};
