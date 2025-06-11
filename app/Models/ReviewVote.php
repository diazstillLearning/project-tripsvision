<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewVote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'review_id',
        'is_helpful',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_helpful' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the review that the vote belongs to.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Scope a query to only include helpful votes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHelpful($query)
    {
        return $query->where('is_helpful', true);
    }

    /**
     * Scope a query to only include not helpful votes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotHelpful($query)
    {
        return $query->where('is_helpful', false);
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Update review vote counts when vote is created, updated, or deleted
        static::created(function ($vote) {
            $vote->review->updateVoteCounts();
        });

        static::updated(function ($vote) {
            $vote->review->updateVoteCounts();
        });

        static::deleted(function ($vote) {
            $vote->review->updateVoteCounts();
        });
    }

    /**
     * Check if a user has voted on a review.
     *
     * @param int $userId
     * @param int $reviewId
     * @return bool
     */
    public static function hasUserVoted(int $userId, int $reviewId): bool
    {
        return static::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->exists();
    }

    /**
     * Get user's vote for a review.
     *
     * @param int $userId
     * @param int $reviewId
     * @return ReviewVote|null
     */
    public static function getUserVote(int $userId, int $reviewId): ?ReviewVote
    {
        return static::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->first();
    }

    /**
     * Toggle user's vote on a review.
     *
     * @param int $userId
     * @param int $reviewId
     * @param bool $isHelpful
     * @return array
     */
    public static function toggleVote(int $userId, int $reviewId, bool $isHelpful): array
    {
        $existingVote = static::getUserVote($userId, $reviewId);

        if ($existingVote) {
            if ($existingVote->is_helpful === $isHelpful) {
                // Same vote - remove it
                $existingVote->delete();
                return [
                    'action' => 'removed',
                    'vote' => null
                ];
            } else {
                // Different vote - update it
                $existingVote->update(['is_helpful' => $isHelpful]);
                return [
                    'action' => 'updated',
                    'vote' => $existingVote->fresh()
                ];
            }
        } else {
            // No existing vote - create new one
            $newVote = static::create([
                'user_id' => $userId,
                'review_id' => $reviewId,
                'is_helpful' => $isHelpful
            ]);
            return [
                'action' => 'created',
                'vote' => $newVote
            ];
        }
    }
}