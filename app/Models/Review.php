<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'destination_id',
        'rating',
        'comment',
        'status',
        'is_featured',
        'helpful_votes',
        'total_votes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'helpful_votes' => 'integer',
        'total_votes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = [
        'formatted_date',
        'is_recent',
        'helpfulness_ratio'
    ];

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the destination that the review belongs to.
     * Note: menggunakan id_destinations sebagai foreign key
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id_destinations');
    }

    /**
     * Get the votes for this review.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(ReviewVote::class);
    }

    /**
     * Get helpful votes only.
     */
    public function helpfulVotes(): HasMany
    {
        return $this->hasMany(ReviewVote::class)->where('is_helpful', true);
    }

    /**
     * Get not helpful votes only.
     */
    public function notHelpfulVotes(): HasMany
    {
        return $this->hasMany(ReviewVote::class)->where('is_helpful', false);
    }

    /**
     * Get formatted date for the review.
     *
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        $diffInDays = $this->created_at->diffInDays(now());
        
        if ($diffInDays === 0) {
            return 'Today';
        } elseif ($diffInDays === 1) {
            return 'Yesterday';
        } elseif ($diffInDays < 7) {
            return $diffInDays . ' days ago';
        } elseif ($diffInDays < 30) {
            $weeks = floor($diffInDays / 7);
            return $weeks === 1 ? '1 week ago' : $weeks . ' weeks ago';
        } elseif ($diffInDays < 365) {
            $months = floor($diffInDays / 30);
            return $months === 1 ? '1 month ago' : $months . ' months ago';
        } else {
            return $this->created_at->format('M d, Y');
        }
    }

    /**
     * Check if the review is recent (within 7 days).
     *
     * @return bool
     */
    public function getIsRecentAttribute(): bool
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }

    /**
     * Get helpfulness ratio (helpful votes / total votes).
     *
     * @return float
     */
    public function getHelpfulnessRatioAttribute(): float
    {
        if ($this->total_votes === 0) {
            return 0;
        }
        return round(($this->helpful_votes / $this->total_votes) * 100, 1);
    }

    /**
     * Scope a query to only include approved reviews.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include reviews with a specific rating.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $rating
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope a query to only include recent reviews.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to only include featured reviews.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by helpfulness.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByHelpfulness($query)
    {
        return $query->orderByDesc('helpful_votes')->orderByDesc('total_votes');
    }

    /**
     * Get reviews for a specific destination with user data.
     *
     * @param int $destinationId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDestinationReviews(int $destinationId, int $limit = 10)
    {
        return static::with(['user:id,username,email'])
            ->approved()
            ->where('destination_id', $destinationId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get average rating for a destination.
     *
     * @param int $destinationId
     * @return float
     */
    public static function getAverageRating(int $destinationId): float
    {
        return (float) static::approved()
            ->where('destination_id', $destinationId)
            ->avg('rating') ?: 0.0;
    }

    /**
     * Get total reviews count for a destination.
     *
     * @param int $destinationId
     * @return int
     */
    public static function getTotalReviews(int $destinationId): int
    {
        return static::approved()->where('destination_id', $destinationId)->count();
    }

    /**
     * Get rating distribution for a destination.
     *
     * @param int $destinationId
     * @return array
     */
    public static function getRatingDistribution(int $destinationId): array
    {
        $distribution = static::approved()
            ->where('destination_id', $destinationId)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')
            ->toArray();

        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($distribution[$i])) {
                $distribution[$i] = 0;
            }
        }

        ksort($distribution);
        return $distribution;
    }

    /**
     * Check if a user has reviewed a destination.
     *
     * @param int $userId
     * @param int $destinationId
     * @return bool
     */
    public static function hasUserReviewed(int $userId, int $destinationId): bool
    {
        return static::where('user_id', $userId)
            ->where('destination_id', $destinationId)
            ->exists();
    }

    /**
     * Get user's review for a destination.
     *
     * @param int $userId
     * @param int $destinationId
     * @return Review|null
     */
    public static function getUserReview(int $userId, int $destinationId): ?Review
    {
        return static::where('user_id', $userId)
            ->where('destination_id', $destinationId)
            ->first();
    }

    /**
     * Vote on this review.
     *
     * @param int $userId
     * @param bool $isHelpful
     * @return bool
     */
    public function vote(int $userId, bool $isHelpful): bool
    {
        // Check if user already voted
        $existingVote = ReviewVote::where('user_id', $userId)
            ->where('review_id', $this->id)
            ->first();

        if ($existingVote) {
            // Update existing vote if different
            if ($existingVote->is_helpful !== $isHelpful) {
                $existingVote->update(['is_helpful' => $isHelpful]);
                $this->updateVoteCounts();
                return true;
            }
            return false; // Same vote, no change
        }

        // Create new vote
        ReviewVote::create([
            'user_id' => $userId,
            'review_id' => $this->id,
            'is_helpful' => $isHelpful
        ]);

        $this->updateVoteCounts();
        return true;
    }

    /**
     * Update vote counts.
     */
    public function updateVoteCounts(): void
    {
        $helpfulCount = $this->votes()->where('is_helpful', true)->count();
        $totalCount = $this->votes()->count();

        $this->update([
            'helpful_votes' => $helpfulCount,
            'total_votes' => $totalCount
        ]);
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Update destination rating when review is created, updated, or deleted
        static::created(function ($review) {
            if ($review->status === 'approved') {
                $review->updateDestinationRating();
            }
        });

        static::updated(function ($review) {
            if ($review->wasChanged('status') || $review->wasChanged('rating')) {
                $review->updateDestinationRating();
            }
        });

        static::deleted(function ($review) {
            $review->updateDestinationRating();
        });
    }

    /**
     * Update the destination's average rating and review count.
     */
    protected function updateDestinationRating(): void
    {
        $destination = $this->destination;
        
        if ($destination) {
            $avgRating = static::approved()
                ->where('destination_id', $this->destination_id)
                ->avg('rating');
            $totalReviews = static::approved()
                ->where('destination_id', $this->destination_id)
                ->count();
            
            $destination->update([
                'average_rating' => round($avgRating ?: 0, 2),
                'total_reviews' => $totalReviews
            ]);
        }
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        
        // Add user name if user relationship is loaded
        if ($this->relationLoaded('user') && $this->user) {
            $array['user']['name'] = $this->user->username;
            $array['user']['avatar'] = $this->user->avatar ?? null;
        }
        
        return $array;
    }
}