<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danau Toba - tripsVision</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destination-detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <a href="#" class="logo">trips<span>Vision</span></a>
        <ul class="navbar">
            <li><a href="/">Home</a></li>
            <li><a href="/planner">Plan</a></li>
            <li><a href="/destinations">Destinations</a></li>
            <li><a href="/culinary">Culinary</a></li>
            <li><a href="/stay">Stay</a></li>
        </ul>
        <div class="h-right">
            <a href="#"><i class="ri-search-line"></i></a>
            <a href="#"><i class="bx bx-user"></i></a>
            <a href="/logout">Logout</a>
        </div>
    </header>

    <!-- Destination Detail Section -->
    <section class="destination-detail">
        <div class="container">
            <!-- Hero Section -->
            <div class="detail-hero">
                <div class="hero-content">
                    <div class="breadcrumb">
                        <a href="/">Home</a>
                        <span><i class="ri-arrow-right-s-line"></i></span>
                        <a href="/destinations">Destinations</a>
                        <span><i class="ri-arrow-right-s-line"></i></span>
                        <span>Danau Toba</span>
                    </div>
                    <h1>Danau Toba</h1>
                    <div class="hero-meta">
                        <div class="location">
                            <i class="ri-map-pin-line"></i>
                            <span>Sumatera Utara, Indonesia</span>
                        </div>
                        <div class="rating">
                            <div class="stars">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-line"></i>
                            </div>
                            <span class="rating-score">4.5</span>
                            <span class="rating-count">(124 reviews)</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/imagesProperty/danauToba.jpg') }}" alt="Danau Toba">
                    <div class="image-overlay">
                        <button class="view-gallery-btn">
                            <i class="ri-image-line"></i>
                            View Gallery
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="detail-content">
                <!-- Description Section -->
                <div class="content-section description-section">
                    <h2>About Danau Toba</h2>
                    <div class="description-content">
                        <p>
                            Danau Toba adalah danau vulkanik terbesar di dunia yang terletak di Sumatera Utara, Indonesia. 
                            Danau ini terbentuk dari letusan gunung berapi super yang terjadi sekitar 70.000 tahun yang lalu. 
                            Dengan luas sekitar 1.145 km², Danau Toba menjadi salah satu destinasi wisata paling populer di Indonesia.
                        </p>
                        <p>
                            Di tengah danau terdapat Pulau Samosir yang merupakan rumah bagi suku Batak Toba dengan budaya yang kaya. 
                            Pengunjung dapat menikmati pemandangan yang menakjubkan, udara sejuk pegunungan, dan berbagai aktivitas wisata 
                            seperti berenang, berperahu, atau mengeksplorasi desa-desa tradisional Batak.
                        </p>
                        <div class="highlights">
                            <h3>Highlights</h3>
                            <ul>
                                <li><i class="ri-check-line"></i> Danau vulkanik terbesar di dunia</li>
                                <li><i class="ri-check-line"></i> Pulau Samosir dengan budaya Batak yang unik</li>
                                <li><i class="ri-check-line"></i> Pemandangan alam yang spektakuler</li>
                                <li><i class="ri-check-line"></i> Air terjun Sipiso-piso yang menakjubkan</li>
                                <li><i class="ri-check-line"></i> Desa wisata tradisional</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div class="content-section facilities-section">
                    <h2>Facilities & Amenities</h2>
                    <div class="facilities-grid">
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-hotel-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Accommodation</h4>
                                <p>Hotels, resorts, guesthouses around the lake</p>
                            </div>
                        </div>
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-restaurant-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Restaurants</h4>
                                <p>Local Batak cuisine and international food</p>
                            </div>
                        </div>
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-car-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Transportation</h4>
                                <p>Ferry, car rental, motorcycle rental</p>
                            </div>
                        </div>
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-swimming-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Water Activities</h4>
                                <p>Swimming, boating, jet skiing, fishing</p>
                            </div>
                        </div>
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-shopping-bag-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Shopping</h4>
                                <p>Souvenir shops, traditional crafts, local products</p>
                            </div>
                        </div>
                        <div class="facility-item">
                            <div class="facility-icon">
                                <i class="ri-hospital-line"></i>
                            </div>
                            <div class="facility-info">
                                <h4>Medical</h4>
                                <p>Clinics and pharmacies available</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="content-section reviews-section">
                    <div class="reviews-header">
                        <h2>Reviews & Comments</h2>
                        <div class="rating-summary">
                            <div class="overall-rating">
                                <span class="rating-number">4.5</span>
                                <div class="rating-stars">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-line"></i>
                                </div>
                                <span class="rating-text">Based on 124 reviews</span>
                            </div>
                            <button class="write-review-btn" onclick="toggleReviewForm()">
                                <i class="ri-edit-line"></i>
                                Write a Review
                            </button>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <div class="review-form-container" id="reviewForm" style="display: none;">
                        <form class="review-form" id="submitReviewForm">
                            <h3>Write Your Review</h3>
                            <div class="form-group">
                                <label>Your Rating</label>
                                <div class="star-rating" id="starRating">
                                    <i class="ri-star-line" data-rating="1"></i>
                                    <i class="ri-star-line" data-rating="2"></i>
                                    <i class="ri-star-line" data-rating="3"></i>
                                    <i class="ri-star-line" data-rating="4"></i>
                                    <i class="ri-star-line" data-rating="5"></i>
                                </div>
                                <input type="hidden" id="rating" name="rating" value="0">
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Comment</label>
                                <textarea id="comment" name="comment" placeholder="Share your experience about this destination..." required></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn-cancel" onclick="toggleReviewForm()">Cancel</button>
                                <button type="submit" class="btn-submit">Submit Review</button>
                            </div>
                        </form>
                    </div>

                    <!-- Reviews List -->
                    <div class="reviews-list" id="reviewsList">
                        <!-- Sample Review 1 -->
                        <div class="review-item" data-review-id="1">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="John Doe">
                                    </div>
                                    <div class="reviewer-details">
                                        <h4>John Doe</h4>
                                        <span class="review-date">2 days ago</span>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                </div>
                                <div class="review-actions">
                                    <button class="action-btn edit-btn" onclick="editReview(1)">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteReview(1)">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Amazing place! The view is absolutely breathtaking. Danau Toba is definitely a must-visit destination in Indonesia. The water is crystal clear and the surrounding mountains create a perfect scenic backdrop. Highly recommended for anyone looking for a peaceful getaway.</p>
                            </div>
                        </div>

                        <!-- Sample Review 2 -->
                        <div class="review-item" data-review-id="2">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b5c3?w=100&h=100&fit=crop&crop=face" alt="Sarah Wilson">
                                    </div>
                                    <div class="reviewer-details">
                                        <h4>Sarah Wilson</h4>
                                        <span class="review-date">1 week ago</span>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-line"></i>
                                </div>
                                <div class="review-actions">
                                    <button class="action-btn edit-btn" onclick="editReview(2)">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteReview(2)">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Great destination for family vacation. The culture at Samosir Island is fascinating and the local people are very friendly. Food was delicious too! Only downside was the transportation to get there took quite long, but it's worth it.</p>
                            </div>
                        </div>

                        <!-- Sample Review 3 -->
                        <div class="review-item" data-review-id="3">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Mike Chen">
                                    </div>
                                    <div class="reviewer-details">
                                        <h4>Mike Chen</h4>
                                        <span class="review-date">2 weeks ago</span>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-line"></i>
                                </div>
                                <div class="review-actions">
                                    <button class="action-btn edit-btn" onclick="editReview(3)">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteReview(3)">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Perfect place for photography enthusiasts! Every corner offers a new perspective. The sunrise and sunset views are spectacular. I spent 3 days here and it wasn't enough. Planning to come back next year!</p>
                            </div>
                        </div>

                        <!-- Load More Button -->
                        <div class="load-more-container">
                            <button class="btn load-more-btn" onclick="loadMoreReviews()">
                                <i class="ri-arrow-down-line"></i>
                                Load More Reviews
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Nearby Attractions -->
                <div class="content-section nearby-section">
                    <h2>Nearby Attractions</h2>
                    <div class="nearby-grid">
                        <div class="nearby-item">
                            <img src="{{ asset('assets/imagesProperty/sipiso-piso.jpg') }}" alt="Sipiso-piso Waterfall">
                            <div class="nearby-info">
                                <h4>Sipiso-piso Waterfall</h4>
                                <p class="distance"><i class="ri-map-pin-line"></i> 45 km from Danau Toba</p>
                                <p>Spectacular waterfall with 120m height offering stunning views of Lake Toba.</p>
                            </div>
                        </div>
                        <div class="nearby-item">
                            <img src="{{ asset('assets/imagesProperty/samosir-island.jpg') }}" alt="Samosir Island">
                            <div class="nearby-info">
                                <h4>Samosir Island</h4>
                                <p class="distance"><i class="ri-map-pin-line"></i> In the middle of Lake Toba</p>
                                <p>Cultural heart of Batak Toba with traditional villages and ancient stone tombs.</p>
                            </div>
                        </div>
                        <div class="nearby-item">
                            <img src="{{ asset('assets/imagesProperty/tomok-village.jpg') }}" alt="Tomok Village">
                            <div class="nearby-info">
                                <h4>Tomok Village</h4>
                                <p class="distance"><i class="ri-map-pin-line"></i> 15 km from Parapat</p>
                                <p>Traditional Batak village with ancient stone sarcophagi and cultural performances.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Review Modal -->
    <div class="modal-overlay" id="editModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Review</h3>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <form class="modal-form" id="editReviewForm">
                <div class="form-group">
                    <label>Your Rating</label>
                    <div class="star-rating" id="editStarRating">
                        <i class="ri-star-line" data-rating="1"></i>
                        <i class="ri-star-line" data-rating="2"></i>
                        <i class="ri-star-line" data-rating="3"></i>
                        <i class="ri-star-line" data-rating="4"></i>
                        <i class="ri-star-line" data-rating="5"></i>
                    </div>
                    <input type="hidden" id="editRating" name="rating" value="0">
                    <input type="hidden" id="editReviewId" name="review_id" value="">
                </div>
                <div class="form-group">
                    <label for="editComment">Your Comment</label>
                    <textarea id="editComment" name="comment" placeholder="Share your experience about this destination..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update Review</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal" style="display: none;">
        <div class="modal-content delete-modal">
            <div class="modal-header">
                <h3>Delete Review</h3>
                <button class="modal-close" onclick="closeDeleteModal()">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this review? This action cannot be undone.</p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn-delete" onclick="confirmDelete()">Delete Review</button>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <div class="toast-content">
            <i class="toast-icon"></i>
            <span class="toast-message"></span>
        </div>
    </div>

    <script src="{{ asset('js/destination-detail.js') }}"></script>
</body>
</html>