<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_destinations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'price',
        'price_range',
        'rating',
        'description',
        'category',
        'image_url',
        'image_url2',
        'image_url3',
        'latitude',
        'longitude',
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
        'contact_info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'facilities' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'total_reviews' => 'integer',
    ];

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = [
        'rating_percentage',
        'featured_image_url',
        'gallery_urls',
        'formatted_facilities',
        'price_formatted'
    ];

    /**
     * Get the reviews for the destination.
     * Note: menggunakan id_destinations sebagai local key
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'destination_id', 'id_destinations');
    }

    /**
     * Get approved reviews for the destination.
     */
    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'destination_id', 'id_destinations')
                    ->where('status', 'approved');
    }

    /**
     * Get recent reviews for the destination.
     */
    public function recentReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'destination_id', 'id_destinations')
                    ->where('status', 'approved')
                    ->latest()
                    ->limit(5);
    }

    /**
     * Get featured reviews for the destination.
     */
    public function featuredReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'destination_id', 'id_destinations')
                    ->where('status', 'approved')
                    ->where('is_featured', true);
    }

    /**
     * Get rating percentage (for display purposes).
     *
     * @return float
     */
    public function getRatingPercentageAttribute(): float
    {
        return ($this->average_rating / 5) * 100;
    }

    /**
     * Get featured image URL.
     *
     * @return string|null
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->image_url) {
            // Check if it's already a full URL
            if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
                return $this->image_url;
            }
            return asset('storage/' . $this->image_url);
        }
        return null;
    }

    /**
     * Get gallery URLs.
     *
     * @return array
     */
    public function getGalleryUrlsAttribute(): array
    {
        $gallery = [];
        
        // Add main images
        if ($this->image_url) $gallery[] = $this->featured_image_url;
        if ($this->image_url2) {
            $gallery[] = filter_var($this->image_url2, FILTER_VALIDATE_URL) 
                ? $this->image_url2 
                : asset('storage/' . $this->image_url2);
        }
        if ($this->image_url3) {
            $gallery[] = filter_var($this->image_url3, FILTER_VALIDATE_URL) 
                ? $this->image_url3 
                : asset('storage/' . $this->image_url3);
        }
        
        // Add additional gallery images
        if ($this->gallery) {
            foreach ($this->gallery as $image) {
                $gallery[] = filter_var($image, FILTER_VALIDATE_URL) 
                    ? $image 
                    : asset('storage/' . $image);
            }
        }
        
        return array_unique($gallery);
    }

    /**
     * Get formatted facilities list.
     *
     * @return array
     */
    public function getFormattedFacilitiesAttribute(): array
    {
        if (!$this->facilities) {
            return [];
        }

        $facilityIcons = [
            'accommodation' => 'ri-hotel-line',
            'restaurant' => 'ri-restaurant-line',
            'transportation' => 'ri-car-line',
            'water_activities' => 'ri-swimming-line',
            'shopping' => 'ri-shopping-bag-line',
            'medical' => 'ri-hospital-line',
            'parking' => 'ri-parking-line',
            'toilet' => 'ri-home-line',
            'wifi' => 'ri-wifi-line',
            'guide' => 'ri-user-line',
            'atm' => 'ri-bank-card-line',
            'security' => 'ri-shield-check-line',
        ];

        return array_map(function($facility) use ($facilityIcons) {
            return [
                'name' => $facility,
                'icon' => $facilityIcons[$facility] ?? 'ri-check-line',
                'formatted_name' => ucwords(str_replace('_', ' ', $facility))
            ];
        }, $this->facilities);
    }

    /**
     * Get formatted price.
     *
     * @return string
     */
    public function getPriceFormattedAttribute(): string
    {
        if ($this->price_range) {
            return $this->price_range;
        }
        
        if ($this->price) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }
        
        return 'Contact for price';
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });

        static::updating(function ($destination) {
            if ($destination->isDirty('name') && empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    /**
     * Scope a query to only include active destinations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured destinations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to filter by category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by location.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $location
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', 'LIKE', "%{$location}%");
    }

    /**
     * Scope a query to order by rating.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByRating($query, string $direction = 'desc')
    {
        return $query->orderBy('average_rating', $direction);
    }

    /**
     * Scope a query to search destinations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('location', 'LIKE', "%{$search}%")
              ->orWhere('category', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by price range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $minPrice
     * @param float $maxPrice
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriceRange($query, float $minPrice, float $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Get destinations within a certain radius of coordinates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $latitude
     * @param float $longitude
     * @param float $radius (in kilometers)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithinRadius($query, float $latitude, float $longitude, float $radius = 50)
    {
        return $query->whereRaw("
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?
        ", [$latitude, $longitude, $latitude, $radius]);
    }

    /**
     * Get popular destinations based on reviews and ratings.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPopular(int $limit = 10)
    {
        return static::active()
            ->where('total_reviews', '>', 0)
            ->orderByRaw('(average_rating * total_reviews) DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Get destinations by category with pagination.
     *
     * @param string $category
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getByCategory(string $category, int $perPage = 12)
    {
        return static::active()
            ->byCategory($category)
            ->orderByRating()
            ->paginate($perPage);
    }

    /**
     * Get similar destinations based on category and location.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSimilar(int $limit = 6)
    {
        return static::active()
            ->where('id_destinations', '!=', $this->id_destinations)
            ->where(function($query) {
                $query->where('category', $this->category)
                      ->orWhere('location', 'LIKE', '%' . explode(',', $this->location)[0] . '%');
            })
            ->orderByRating()
            ->limit($limit)
            ->get();
    }

    /**
     * Update rating and review count.
     */
    public function updateRatingStats(): void
    {
        $avgRating = $this->approvedReviews()->avg('rating') ?: 0;
        $totalReviews = $this->approvedReviews()->count();
        
        $this->update([
            'average_rating' => round($avgRating, 2),
            'total_reviews' => $totalReviews
        ]);
    }

    /**
     * Check if destination has facilities.
     *
     * @param string $facility
     * @return bool
     */
    public function hasFacility(string $facility): bool
    {
        if (!$this->facilities) {
            return false;
        }

        return in_array($facility, $this->facilities);
    }

    /**
     * Get highlights as array.
     *
     * @return array
     */
    public function getHighlightsArray(): array
    {
        if (!$this->highlights) {
            return [];
        }

        // Split by | or newline
        return array_filter(array_map('trim', preg_split('/\||\n/', $this->highlights)));
    }

    /**
     * Get route key for model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}