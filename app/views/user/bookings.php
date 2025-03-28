<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- User Bookings Section -->
<section class="user-bookings-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Bookings</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="user-sidebar card shadow-sm">
                    <div class="card-body p-0">
                        <div class="user-info text-center p-4 border-bottom">
                            <div class="user-avatar mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                            <h4 class="mb-0"><?php echo $_SESSION['user_name']; ?></h4>
                            <p class="text-muted mb-0"><?php echo $_SESSION['user_email']; ?></p>
                        </div>
                        <div class="user-menu">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/user/profile" class="d-flex align-items-center">
                                        <i class="fas fa-user me-3"></i> My Profile
                                    </a>
                                </li>
                                <li class="list-group-item active">
                                    <a href="<?php echo URLROOT; ?>/user/bookings" class="d-flex align-items-center">
                                        <i class="fas fa-calendar-check me-3"></i> My Bookings
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/user/settings" class="d-flex align-items-center">
                                        <i class="fas fa-cog me-3"></i> Account Settings
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/auth/logout" class="d-flex align-items-center text-danger">
                                        <i class="fas fa-sign-out-alt me-3"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Statistics -->
                <div class="booking-stats card shadow-sm mt-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="card-title mb-0">Booking Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="stat-card text-center p-3 bg-light rounded">
                                    <h3 class="text-primary mb-0"><?php echo count($data['pendingBookings']); ?></h3>
                                    <p class="text-muted mb-0">Pending</p>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-card text-center p-3 bg-light rounded">
                                    <h3 class="text-success mb-0"><?php echo count($data['confirmedBookings']); ?></h3>
                                    <p class="text-muted mb-0">Confirmed</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3 bg-light rounded">
                                    <h3 class="text-info mb-0"><?php echo count($data['completedBookings']); ?></h3>
                                    <p class="text-muted mb-0">Completed</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3 bg-light rounded">
                                    <h3 class="text-danger mb-0"><?php echo count($data['cancelledBookings']); ?></h3>
                                    <p class="text-muted mb-0">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bookings Content -->
            <div class="col-lg-9">
                <!-- Bookings Navigation -->
                <ul class="nav nav-tabs mb-4" id="bookingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                            All Bookings (<?php echo count($data['bookings']); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">
                            Pending (<?php echo count($data['pendingBookings']); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button" role="tab" aria-controls="confirmed" aria-selected="false">
                            Confirmed (<?php echo count($data['confirmedBookings']); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                            Completed (<?php echo count($data['completedBookings']); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">
                            Cancelled (<?php echo count($data['cancelledBookings']); ?>)
                        </button>
                    </li>
                </ul>
                
                <!-- Bookings Tab Content -->
                <div class="tab-content" id="bookingsTabContent">
                    <!-- All Bookings Tab -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <?php if (empty($data['bookings'])): ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                </div>
                                <h5>No Bookings Found</h5>
                                <p class="text-muted">You haven't made any bookings yet.</p>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary">Browse Cars</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['bookings'] as $booking): ?>
                                <div class="booking-card card shadow-sm mb-4">
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <!-- Car Image -->
                                            <div class="col-md-3">
                                                <div class="booking-car-image h-100">
                                                    <img src="<?php echo !empty($booking['image']) ? URLROOT . '/uploads/cars/' . $booking['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                                                         alt="<?php echo $booking['brand'] . ' ' . $booking['model']; ?>" 
                                                         class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                </div>
                                            </div>
                                            
                                            <!-- Booking Details -->
                                            <div class="col-md-9">
                                                <div class="booking-details p-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h5 class="mb-1"><?php echo $booking['brand'] . ' ' . $booking['model']; ?></h5>
                                                            <p class="text-muted mb-0">Booking #<?php echo $booking['id']; ?> - <?php echo formatDate($booking['created_at']); ?></p>
                                                        </div>
                                                        <div>
                                                            <?php if($booking['status'] == 'pending'): ?>
                                                                <span class="badge bg-warning">Pending</span>
                                                            <?php elseif($booking['status'] == 'confirmed'): ?>
                                                                <span class="badge bg-success">Confirmed</span>
                                                            <?php elseif($booking['status'] == 'completed'): ?>
                                                                <span class="badge bg-primary">Completed</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="booking-info-item">
                                                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                                <span class="text-muted">Pickup:</span>
                                                                <strong><?php echo formatDate($booking['pickup_date']); ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="booking-info-item">
                                                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                                                <span class="text-muted">Return:</span>
                                                                <strong><?php echo formatDate($booking['return_date']); ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="booking-info-item">
                                                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                                <span class="text-muted">Location:</span>
                                                                <strong><?php echo $booking['pickup_location']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="booking-info-item">
                                                                <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                                                <span class="text-muted">Total:</span>
                                                                <strong><?php echo formatPrice($booking['total_price']); ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Booking Actions -->
                                                    <div class="booking-actions">
                                                        <a href="<?php echo URLROOT; ?>/booking/confirm/<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="fas fa-eye me-1"></i> View Details
                                                        </a>
                                                        
                                                        <?php if($booking['status'] == 'pending' && $booking['payment_status'] == 'pending'): ?>
                                                            <a href="<?php echo URLROOT; ?>/booking/checkout/<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary me-2">
                                                                <i class="fas fa-credit-card me-1"></i> Pay Now
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($booking['status'] == 'pending' || $booking['status'] == 'confirmed'): ?>
                                                            <a href="<?php echo URLROOT; ?>/booking/cancel/<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger me-2">
                                                                <i class="fas fa-times-circle me-1"></i> Cancel
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($booking['status'] == 'completed'): ?>
                                                            <?php 
                                                                // Check if user has reviewed this booking
                                                                $reviewModel = new Review();
                                                                $hasReviewed = $reviewModel->getReviewByBooking($booking['id']);
                                                            ?>
                                                            
                                                            <?php if(!$hasReviewed): ?>
                                                                <a href="<?php echo URLROOT; ?>/review/add/<?php echo $booking['id']; ?>" class="btn btn-sm btn-warning me-2">
                                                                    <i class="fas fa-star me-1"></i> Leave Review
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Pending Bookings Tab -->
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <?php if (empty($data['pendingBookings'])): ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                </div>
                                <h5>No Pending Bookings</h5>
                                <p class="text-muted">You don't have any pending bookings at the moment.</p>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary">Browse Cars</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['pendingBookings'] as $booking): ?>
                                <div class="booking-card card shadow-sm mb-4">
                                    <!-- Similar structure as in All Bookings tab -->
                                    <!-- Repeated code is omitted for brevity -->
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Confirmed Bookings Tab -->
                    <div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                        <?php if (empty($data['confirmedBookings'])): ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                </div>
                                <h5>No Confirmed Bookings</h5>
                                <p class="text-muted">You don't have any confirmed bookings at the moment.</p>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary">Browse Cars</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['confirmedBookings'] as $booking): ?>
                                <div class="booking-card card shadow-sm mb-4">
                                    <!-- Similar structure as in All Bookings tab -->
                                    <!-- Repeated code is omitted for brevity -->
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Completed Bookings Tab -->
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <?php if (empty($data['completedBookings'])): ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                </div>
                                <h5>No Completed Bookings</h5>
                                <p class="text-muted">You don't have any completed bookings yet.</p>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary">Browse Cars</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['completedBookings'] as $booking): ?>
                                <div class="booking-card card shadow-sm mb-4">
                                    <!-- Similar structure as in All Bookings tab -->
                                    <!-- Repeated code is omitted for brevity -->
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Cancelled Bookings Tab -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <?php if (empty($data['cancelledBookings'])): ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                </div>
                                <h5>No Cancelled Bookings</h5>
                                <p class="text-muted">You don't have any cancelled bookings.</p>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary">Browse Cars</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['cancelledBookings'] as $booking): ?>
                                <div class="booking-card card shadow-sm mb-4">
                                    <!-- Similar structure as in All Bookings tab -->
                                    <!-- Repeated code is omitted for brevity -->
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>