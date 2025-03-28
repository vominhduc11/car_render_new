<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Car Details Section -->
<section class="car-details-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/car">Cars</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Car Images -->
            <div class="col-lg-6 mb-4">
                <div class="car-image-gallery">
                    <div class="main-image mb-3">
                        <img src="<?php echo !empty($data['car']['image']) ? URLROOT . '/uploads/cars/' . $data['car']['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                             alt="<?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?>" 
                             class="img-fluid rounded">
                    </div>
                </div>
                
                <!-- Car Status Badge -->
                <div class="car-status mb-4">
                    <?php if($data['car']['status'] == 'available'): ?>
                        <span class="status-available">Available</span>
                    <?php elseif($data['car']['status'] == 'maintenance'): ?>
                        <span class="status-maintenance">Maintenance</span>
                    <?php else: ?>
                        <span class="status-rented">Rented</span>
                    <?php endif; ?>
                </div>
                
                <!-- Car Features -->
                <div class="car-features">
                    <h4 class="mb-3">Car Features</h4>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-car-side"></i>
                                <span>Brand: <?php echo $data['car']['brand']; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Year: <?php echo $data['car']['year']; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-palette"></i>
                                <span>Color: <?php echo $data['car']['color']; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-user-friends"></i>
                                <span>Seats: <?php echo $data['car']['seats']; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-cogs"></i>
                                <span>Transmission: <?php echo $data['car']['transmission'] == 'auto' ? 'Automatic' : 'Manual'; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-gas-pump"></i>
                                <span>Fuel: <?php echo $data['car']['fuel']; ?></span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-id-card"></i>
                                <span>License Plate: <?php echo $data['car']['license_plate']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Car Details and Booking Form -->
            <div class="col-lg-6">
                <h2 class="car-title mb-3"><?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?></h2>
                
                <!-- Rating -->
                <div class="car-rating mb-3">
                    <?php echo displayStarRating($data['avgRating']); ?>
                    <span class="rating-text"><?php echo $data['avgRating']; ?> (<?php echo count($data['reviews']); ?> reviews)</span>
                </div>
                
                <!-- Price -->
                <div class="car-price mb-4">
                    <h3 class="text-primary"><?php echo formatPrice($data['car']['price_per_day']); ?> <span class="price-unit">/ day</span></h3>
                </div>
                
                <!-- Description -->
                <div class="car-description mb-4">
                    <h4>Description</h4>
                    <p><?php echo !empty($data['car']['description']) ? $data['car']['description'] : 'No description available for this car.'; ?></p>
                </div>
                
                <!-- Booking Form -->
                <div class="booking-form">
                    <h4 class="mb-3">Book This Car</h4>
                    
                    <?php if ($data['car']['status'] != 'available'): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> This car is currently not available for booking.
                        </div>
                    <?php else: ?>
                        <form action="<?php echo URLROOT; ?>/booking/create/<?php echo $data['car']['id']; ?>" method="GET">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_date" class="form-label">Pickup Date</label>
                                    <input type="date" class="form-control" id="pickup_date" name="pickup_date" 
                                           value="<?php echo $data['pickup_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="return_date" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date" 
                                           value="<?php echo $data['return_date']; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                </div>
                            </div>
                            
                            <?php if (!empty($data['pickup_date']) && !empty($data['return_date'])): ?>
                                <?php if ($data['isAvailable']): ?>
                                    <div class="booking-summary mb-3">
                                        <div class="booking-summary-header">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="booking-summary-content">
                                            <div class="booking-summary-item">
                                                <span class="item-label">Duration:</span>
                                                <span class="item-value"><?php echo $data['days']; ?> days</span>
                                            </div>
                                            <div class="booking-summary-item">
                                                <span class="item-label">Price per day:</span>
                                                <span class="item-value"><?php echo formatPrice($data['car']['price_per_day']); ?></span>
                                            </div>
                                            <div class="booking-summary-item total">
                                                <span class="item-label">Total Price:</span>
                                                <span class="item-value"><?php echo formatPrice($data['totalPrice']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if (isLoggedIn()): ?>
                                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Book Now</button>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-primary btn-lg w-100 mb-3">Login to Book</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle me-2"></i> This car is not available for the selected dates.
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary w-100 mb-3">Check Other Dates</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Check Availability</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Car Reviews Section -->
<section class="car-reviews-section py-5 bg-light">
    <div class="container">
        <h3 class="section-title mb-4">Customer Reviews</h3>
        
        <?php if (empty($data['reviews'])): ?>
            <div class="text-center py-4">
                <p class="text-muted">This car has no reviews yet.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Reviews Summary -->
                <div class="col-lg-4 mb-4">
                    <div class="reviews-summary card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h4 class="rating-average"><?php echo $data['avgRating']; ?></h4>
                                <div class="rating-stars">
                                    <?php echo displayStarRating($data['avgRating']); ?>
                                </div>
                                <p class="text-muted"><?php echo count($data['reviews']); ?> reviews</p>
                            </div>
                            
                            <?php 
                                // Get rating counts
                                $ratingModel = new Review();
                                $ratingCounts = $ratingModel->getRatingCount($data['car']['id']);
                                $totalReviews = count($data['reviews']);
                            ?>
                            
                            <!-- Rating Bars -->
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <div class="rating-bar mb-2">
                                    <div class="rating-label">
                                        <?php echo $i; ?> <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                        <?php $percentage = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0; ?>
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage; ?>%" 
                                             aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="rating-count">
                                        <?php echo $ratingCounts[$i]; ?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews List -->
                <div class="col-lg-8">
                    <?php foreach ($data['reviews'] as $review): ?>
                        <div class="review-card card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="review-author">
                                        <h5 class="mb-0"><?php echo $review['full_name']; ?></h5>
                                        <small class="text-muted"><?php echo formatDate($review['created_at']); ?></small>
                                    </div>
                                    <div class="review-rating">
                                        <?php echo displayStarRating($review['rating'], false); ?>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p><?php echo $review['comment']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Similar Cars Section -->
<?php if (!empty($data['similarCars'])): ?>
<section class="similar-cars-section py-5">
    <div class="container">
        <h3 class="section-title mb-4">Similar Cars</h3>
        
        <div class="row">
            <?php foreach ($data['similarCars'] as $car): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="car-card">
                        <div class="car-image">
                            <img src="<?php echo !empty($car['image']) ? URLROOT . '/uploads/cars/' . $car['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                                 alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
                        </div>
                        <div class="car-body">
                            <h5 class="car-title"><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
                            <div class="car-price mb-3"><?php echo formatPrice($car['price_per_day']); ?> / day</div>
                            <div class="car-features mb-3">
                                <span class="car-feature"><i class="fas fa-calendar"></i> <?php echo $car['year']; ?></span>
                                <span class="car-feature"><i class="fas fa-user"></i> <?php echo $car['seats']; ?> Seats</span>
                                <span class="car-feature"><i class="fas fa-cog"></i> <?php echo $car['transmission'] == 'auto' ? 'Auto' : 'Manual'; ?></span>
                            </div>
                            <a href="<?php echo URLROOT; ?>/car/details/<?php echo $car['id']; ?><?php echo (!empty($data['pickup_date']) && !empty($data['return_date'])) ? '?pickup_date=' . $data['pickup_date'] . '&return_date=' . $data['return_date'] : ''; ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- JavaScript for Date Validation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickupDateInput = document.getElementById('pickup_date');
        const returnDateInput = document.getElementById('return_date');
        
        if (pickupDateInput && returnDateInput) {
            // Set minimum return date based on pickup date
            pickupDateInput.addEventListener('change', function() {
                const pickupDate = new Date(this.value);
                const nextDay = new Date(pickupDate);
                nextDay.setDate(pickupDate.getDate() + 1);
                
                const year = nextDay.getFullYear();
                const month = String(nextDay.getMonth() + 1).padStart(2, '0');
                const day = String(nextDay.getDate()).padStart(2, '0');
                
                returnDateInput.min = `${year}-${month}-${day}`;
                
                // Reset return date if it's before the new minimum
                if (new Date(returnDateInput.value) < nextDay) {
                    returnDateInput.value = `${year}-${month}-${day}`;
                }
            });
        }
    });
</script>