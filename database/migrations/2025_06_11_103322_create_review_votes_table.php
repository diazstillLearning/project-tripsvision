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
        Schema::create('review_votes', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            
            // Vote type: true = helpful, false = not helpful
            $table->boolean('is_helpful');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['review_id', 'is_helpful']);
            
            // Unique constraint: satu user hanya bisa vote sekali per review
            $table->unique(['user_id', 'review_id'], 'unique_user_review_vote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_votes');
    }
};