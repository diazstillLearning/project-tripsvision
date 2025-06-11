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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke users table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign key ke destinations table (menggunakan id_destinations)
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id_destinations')->on('destinations')->onDelete('cascade');
            
            // Review data
            $table->tinyInteger('rating')->unsigned()->comment('Rating from 1-5');
            $table->text('comment');
            
            // Status review
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->boolean('is_featured')->default(false); // untuk featured reviews
            
            // Helpful votes (optional feature)
            $table->integer('helpful_votes')->default(0);
            $table->integer('total_votes')->default(0);
            
            $table->timestamps();
            $table->softDeletes(); // untuk soft delete
            
            // Indexes untuk performance
            $table->index(['destination_id', 'created_at']);
            $table->index(['user_id', 'destination_id']);
            $table->index('rating');
            $table->index('status');
            
            // Unique constraint: satu user hanya bisa review satu destinasi sekali
            $table->unique(['user_id', 'destination_id'], 'unique_user_destination_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};