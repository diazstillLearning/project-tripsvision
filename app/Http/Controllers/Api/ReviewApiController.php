<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Destination;
use App\Models\ReviewVote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReviewApiController extends Controller
{
    /**
     * Get reviews for a destination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination_id' => 'required|integer|exists:destinations,id_destinations',
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1|max:50',
                'sort' => 'in:newest,oldest,rating_high,rating_low,helpful'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $destinationId = $request->destination_id;
            $perPage = $request->get('per_page', 10);
            $sort = $request->get('sort', 'newest');

            // Build query
            $query = Review::with(['user:id,username,email'])
                ->approved()
                ->where('destination_id', $destinationId);

            // Apply sorting
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating_high':
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'rating_low':
                    $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                    break;
                case 'helpful':
                    $query->orderByHelpfulness()->orderBy('created_at', 'desc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
            }

            // Get reviews with pagination
            $reviews = $query->paginate($perPage);

            // Get rating summary
            $summary = $this->getRatingSummary($destinationId);

            // Add user vote info if authenticated
            if (Auth::check()) {
                $userId = Auth::id();
                foreach ($reviews->items() as $review) {
                    $userVote = ReviewVote::getUserVote($userId, $review->id);
                    $review->user_vote = $userVote ? $userVote->is_helpful : null;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Reviews retrieved successfully',
                'data' => [
                    'reviews' => $reviews->items(),
                    'summary' => $summary,
                    'pagination' => [
                        'current_page' => $reviews->currentPage(),
                        'last_page' => $reviews->lastPage(),
                        'per_page' => $reviews->perPage(),
                        'total' => $reviews->total(),
                        'has_more' => $reviews->hasMorePages()
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve reviews',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new review
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination_id' => 'required|integer|exists:destinations,id_destinations',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000|min:10'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $destinationId = $request->destination_id;

            // Check if user already reviewed this destination
            $existingReview = Review::where('user_id', $user->id)
                ->where('destination_id', $destinationId)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this destination',
                    'errors' => [
                        'review' => ['You can only review a destination once. Please edit your existing review.']
                    ]
                ], 422);
            }

            // Create new review
            $review = Review::create([
                'user_id' => $user->id,
                'destination_id' => $destinationId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'approved' // Auto approve for now, can be changed to 'pending'
            ]);

            // Load user relationship
            $review->load('user:id,username,email');

            // Get updated rating summary
            $summary = $this->getRatingSummary($destinationId);

            return response()->json([
                'success' => true,
                'message' => 'Review created successfully',
                'data' => [
                    'review' => $review,
                    'summary' => $summary
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific review
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $review = Review::with(['user:id,username,email', 'destination'])
                ->findOrFail($id);

            // Add user vote info if authenticated
            if (Auth::check()) {
                $userVote = ReviewVote::getUserVote(Auth::id(), $review->id);
                $review->user_vote = $userVote ? $userVote->is_helpful : null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Review retrieved successfully',
                'data' => [
                    'review' => $review
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update a review
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000|min:10'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $review = Review::findOrFail($id);

            // Check if user owns this review
            if ($review->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                    'error' => 'You can only edit your own reviews'
                ], 403);
            }

            // Update review
            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            // Load user relationship
            $review->load('user:id,username,email');

            // Get updated rating summary
            $summary = $this->getRatingSummary($review->destination_id);

            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully',
                'data' => [
                    'review' => $review,
                    'summary' => $summary
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a review
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $review = Review::findOrFail($id);

            // Check if user owns this review or is admin
            if ($review->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                    'error' => 'You can only delete your own reviews'
                ], 403);
            }

            $destinationId = $review->destination_id;
            
            // Delete review
            $review->delete();

            // Get updated rating summary
            $summary = $this->getRatingSummary($destinationId);

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully',
                'data' => [
                    'summary' => $summary
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vote on a review (helpful/not helpful)
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function vote(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'is_helpful' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $review = Review::findOrFail($id);

            // Can't vote on own review
            if ($review->user_id === $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot vote on your own review'
                ], 422);
            }

            $result = ReviewVote::toggleVote($user->id, $review->id, $request->is_helpful);

            // Get updated review with vote counts
            $review->fresh();

            return response()->json([
                'success' => true,
                'message' => 'Vote ' . $result['action'] . ' successfully',
                'data' => [
                    'action' => $result['action'],
                    'review' => $review,
                    'user_vote' => $result['vote'] ? $result['vote']->is_helpful : null
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to vote on review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's review for a destination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserReview(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination_id' => 'required|integer|exists:destinations,id_destinations'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $review = Review::where('user_id', $user->id)
                ->where('destination_id', $request->destination_id)
                ->with('user:id,username,email')
                ->first();

            return response()->json([
                'success' => true,
                'message' => $review ? 'User review found' : 'No review found',
                'data' => [
                    'review' => $review,
                    'has_reviewed' => (bool) $review
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get rating summary for a destination
     *
     * @param int $destinationId
     * @return array
     */
    private function getRatingSummary(int $destinationId): array
    {
        $reviews = Review::approved()->where('destination_id', $destinationId);
        
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
        
        // Get rating distribution
        $ratingDistribution = DB::table('reviews')
            ->select('rating', DB::raw('count(*) as count'))
            ->where('destination_id', $destinationId)
            ->where('status', 'approved')
            ->whereNull('deleted_at')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();
        
        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        
        ksort($ratingDistribution);

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'rating_distribution' => $ratingDistribution
        ];
    }

    /**
     * Get reviews by rating
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getReviewsByRating(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination_id' => 'required|integer|exists:destinations,id_destinations',
                'rating' => 'required|integer|min:1|max:5',
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $destinationId = $request->destination_id;
            $rating = $request->rating;
            $perPage = $request->get('per_page', 10);

            $reviews = Review::with(['user:id,username,email'])
                ->approved()
                ->where('destination_id', $destinationId)
                ->where('rating', $rating)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => "Reviews with {$rating} stars retrieved successfully",
                'data' => [
                    'reviews' => $reviews->items(),
                    'pagination' => [
                        'current_page' => $reviews->currentPage(),
                        'last_page' => $reviews->lastPage(),
                        'per_page' => $reviews->perPage(),
                        'total' => $reviews->total(),
                        'has_more' => $reviews->hasMorePages()
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve reviews',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get destination rating summary
     *
     * @param int $destinationId
     * @return JsonResponse
     */
    public function getDestinationSummary(int $destinationId): JsonResponse
    {
        try {
            // Check if destination exists using id_destinations
            $destination = Destination::where('id_destinations', $destinationId)->firstOrFail();
            
            $summary = $this->getRatingSummary($destinationId);

            return response()->json([
                'success' => true,
                'message' => 'Destination rating summary retrieved successfully',
                'data' => [
                    'destination' => $destination,
                    'summary' => $summary
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get destination summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}