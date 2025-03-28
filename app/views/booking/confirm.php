<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Booking Confirmation Section -->
<section class="booking-confirmation-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/user/bookings">My Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking Confirmation</li>
            </ol>
        </nav>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Confirmation Card -->
                <div class="confirmation-card card shadow-sm mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h3 class="card-title mb-0">Booking Confirmed</h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Confirmation Message -->
                        <div class="text-center mb-4">
                            <div class="confirmation-icon mb-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <h4>Thank you for your booking!</h4>
                            <p class="text-muted">Your booking has been created successfully. Your booking ID is <strong>#<?php echo $data['booking']['id']; ?></strong>.</p>
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="booking-details mb-4">
                            <h5 class="mb-3">Booking Details</h5>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Booking ID:</div>
                                <div class="col-8">#<?php echo $data['booking']['id']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Booking Date:</div>
                                <div class="col-8"><?php echo formatDateTime($data['booking']['created_at']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Status:</div>
                                <div class="col-8">
                                    <?php if($data['booking']['status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif($data['booking']['status'] == 'confirmed'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                    <?php elseif($data['booking']['status'] == 'completed'): ?>
                                        <span class="badge bg-primary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Payment Status:</div>
                                <div class="col-8">
                                    <?php if($data['booking']['payment_status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Car Info -->
                        <div class="car-info mb-4">
                            <h5 class="mb-3">Car Information</h5>
                            <div class="d-flex align-items-center">
                                <div class="car-image me-3">
                                    <img src="<?php echo !empty($data['booking']['image']) ? URLROOT . '/uploads/cars/' . $data['booking']['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                                         alt="<?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?>" 
                                         class="img-fluid rounded" style="width: 100px; height: 75px; object-fit: cover;">
                                </div>
                                <div>
                                    <h5 class="mb-1"><?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?></h5>
                                    <p class="text-muted mb-0">License Plate: <?php echo $data['booking']['license_plate']; ?></p>
                                    <p class="mb-0"><?php echo formatPrice($data['booking']['price_per_day']); ?> / day</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rental Details -->
                        <div class="rental-details mb-4">
                            <h5 class="mb-3">Rental Details</h5>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Pickup Date:</div>
                                <div class="col-8"><?php echo formatDate($data['booking']['pickup_date']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Return Date:</div>
                                <div class="col-8"><?php echo formatDate($data['booking']['return_date']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Duration:</div>
                                <div class="col-8"><?php echo calculateDaysBetween($data['booking']['pickup_date'], $data['booking']['return_date']); ?> days</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted">Pickup Location:</div>
                                <div class="col-8"><?php echo $data['booking']['pickup_location']; ?></div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-4 text-muted">Return Location:</div>
                                <div class="col-8"><?php echo $data['booking']['return_location']; ?></div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Payment Details -->
                        <div class="payment-details mb-4">
                            <h5 class="mb-3">Payment Details</h5>
                            <div class="row mb-2">
                                <div class="col-8 text-muted">Total Amount:</div>
                                <div class="col-4 text-end"><strong><?php echo formatPrice($data['booking']['total_price']); ?></strong></div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons d-flex flex-column flex-md-row gap-2 justify-content-center">
                            <?php if($data['booking']['payment_status'] == 'pending'): ?>
                                <a href="<?php echo URLROOT; ?>/booking/checkout/<?php echo $data['booking']['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i> Pay Now
                                </a>
                            <?php endif; ?>
                            
                            <?php if($data['booking']['status'] == 'pending' || $data['booking']['status'] == 'confirmed'): ?>
                                <a href="<?php echo URLROOT; ?>/booking/cancel/<?php echo $data['booking']['id']; ?>" class="btn btn-outline-danger">
                                    <i class="fas fa-times-circle me-2"></i> Cancel Booking
                                </a>
                            <?php endif; ?>
                            
                            <a href="<?php echo URLROOT; ?>/user/bookings" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i> My Bookings
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Important Information -->
                <div class="important-info card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Important Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-info-circle text-primary me-2"></i> <strong>Pickup Time:</strong> Please arrive at least 30 minutes before your scheduled pickup time.</li>
                            <li class="mb-2"><i class="fas fa-info-circle text-primary me-2"></i> <strong>Documents Required:</strong> Please bring your driver's license, ID card, and credit card used for booking.</li>
                            <li class="mb-2"><i class="fas fa-info-circle text-primary me-2"></i> <strong>Cancellation Policy:</strong> Free cancellation up to 24 hours before pickup. After that, a cancellation fee may apply.</li>
                            <li><i class="fas fa-info-circle text-primary me-2"></i> <strong>Contact Information:</strong> For any queries, please contact us at <a href="mailto:support@carrental.com">support@carrental.com</a> or call us at +123 456 7890.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>