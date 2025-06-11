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
        Schema::table('destinations', function (Blueprint $table) {
            // Menambah kolom untuk aggregate review data
            $table->integer('total_reviews')->default(0)->after('rating');
            $table->decimal('average_rating', 3, 2)->default(0)->after('rating');
            
            // Menambah kolom untuk SEO dan detail
            $table->string('slug')->unique()->after('name');
            $table->text('highlights')->nullable()->after('description');
            $table->json('facilities')->nullable()->after('highlights'); // Array facilities
            $table->json('gallery')->nullable()->after('image_url3'); // Array gambar tambahan
            
            // Status dan featured
            $table->boolean('is_featured')->default(false)->after('gallery');
            $table->boolean('is_active')->default(true)->after('is_featured');
            
            // Additional info
            $table->string('opening_hours')->nullable()->after('is_active');
            $table->text('best_time_to_visit')->nullable()->after('opening_hours');
            $table->string('contact_info')->nullable()->after('best_time_to_visit');
            
            // Indexes
            $table->index(['is_active', 'is_featured']);
            $table->index('category');
            $table->index('average_rating');
            $table->index('total_reviews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['category']);
            $table->dropIndex(['average_rating']);
            $table->dropIndex(['total_reviews']);
            
            $table->dropColumn([
                'total_reviews',
                'average_rating',
                'slug',
                'highlights',
                'facilities',
                'gallery',
                'is_featured',
                'is_active',
                'opening_hours',
                'best_time_to_visit',
                'contact_info'
            ]);
        });
    }
};