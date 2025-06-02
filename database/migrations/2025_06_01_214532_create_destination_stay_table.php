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
    Schema::create('destination_stay', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_destinations');
        $table->unsignedBigInteger('id_stays');

        // Foreign keys
        $table->foreign('id_destinations')->references('id_destinations')->on('destinations')->onDelete('cascade');
        $table->foreign('id_stays')->references('id_stays')->on('stays')->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_stay');
    }
};
