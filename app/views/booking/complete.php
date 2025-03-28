<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Booking Complete Section -->
<section class="booking-complete-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/user/bookings">My Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Complete</li>
            </ol>
        </nav>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Card -->
                <div class="success-card card shadow-sm mb-4">
                    <div class="card-body text-center p-5">
                        <div class="success-icon mb-4">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h2 class="success-title mb-3">Payment Successful!</h2>
                        <p class="success-message mb-4">Your payment has been processed successfully. Your booking is now confirmed.</p>
                        <div class="booking-info mb-4">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="booking-details p-3 rounded bg-light">
                                        <div class="booking-id mb-3">
                                            <h5>Booking #<?php echo $data['booking']['id']; ?></h5>
                                        </div>
                                        <div class="booking-car mb-3">
                                            <p class="mb-0"><strong><?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?></strong></p>
                                            <p class="text-muted mb-0"><?php echo formatDate($data['booking']['pickup_date']); ?> - <?php echo formatDate($data['booking']['return_date']); ?></p>
                                        </div>
                                        <div class="booking-amount">
                                            <p class="mb-0"><strong>Total Amount:</strong> <?php echo formatPrice($data['booking']['total_price']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="receipt-info mb-4">
                            <p>A receipt has been sent to your email at <strong><?php echo $_SESSION['user_email']; ?></strong></p>
                        </div>
                        <div class="action-buttons">
                            <a href="<?php echo URLROOT; ?>/booking/confirm/<?php echo $data['booking']['id']; ?>" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-eye me-2"></i> View Booking
                            </a>
                            <a href="<?php echo URLROOT; ?>/user/bookings" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list me-2"></i> My Bookings
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- What's Next -->
                <div class="whats-next card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h4 class="card-title mb-0">What's Next?</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="next-steps">
                            <div class="step d-flex mb-4">
                                <div class="step-icon me-3">
                                    <div class="icon-circle bg-primary text-white">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="step-content">
                                    <h5>Check Your Email</h5>
                                    <p class="text-muted mb-0">We've sent a confirmation email with all the details of your booking.</p>
                                </div>
                            </div>
                            <div class="step d-flex mb-4">
                                <div class="step-icon me-3">
                                    <div class="icon-circle bg-primary text-white">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                                <div class="step-content">
                                    <h5>Prepare Documents</h5>
                                    <p class="text-muted mb-0">Make sure to bring your driver's license, ID card, and the credit card used for payment.</p>
                                </div>
                            </div>
                            <div class="step d-flex">
                                <div class="step-icon me-3">
                                    <div class="icon-circle bg-primary text-white">
                                        <i class="fas fa-car"></i>
                                    </div>
                                </div>
                                <div class="step-content">
                                    <h5>Pickup Your Car</h5>
                                    <p class="text-muted mb-0">Arrive at the pickup location at least 30 minutes before your scheduled time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Need Help? -->
                <div class="need-help card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="help-icon me-4">
                            <i class="fas fa-headset fa-3x text-primary"></i>
                        </div>
                        <div class="help-content">
                            <h5 class="mb-2">Need Help?</h5>
                            <p class="mb-3">If you have any questions about your booking, please contact our customer support.</p>
                            <a href="<?php echo URLROOT; ?>/home/contact" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- More Cars Section -->
<section class="more-cars-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Explore More Cars</h2>
            <p class="section-subtitle">Discover our premium selection for your next adventure</p>
        </div>
        
        <div class="row">
            <?php 
                // Get some random available cars
                $carModel = new Car();
                $cars = $carModel->getCars(['status' => 'available'], 'id', 'RAND()', 3);
            ?>
            
            <?php foreach($cars as $car): ?>
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
                            <a href="<?php echo URLROOT; ?>/car/details/<?php echo $car['id']; ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-3">
            <a href="<?php echo URLROOT; ?>/car" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-car me-2"></i> Browse All Cars
            </a>
        </div>
    </div>
</section>

<!-- Print Booking Receipt -->
<div class="modal fade" id="printReceiptModal" tabindex="-1" aria-labelledby="printReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printReceiptModalLabel">Booking Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="printReceiptContent">
                <!-- Receipt Content -->
                <div class="receipt-header text-center mb-4">
                    <h3><?php echo SITENAME; ?></h3>
                    <p>Booking Receipt</p>
                </div>
                
                <div class="receipt-info mb-4">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Booking #:</strong> <?php echo $data['booking']['id']; ?></p>
                            <p><strong>Date:</strong> <?php echo formatDate(date('Y-m-d')); ?></p>
                        </div>
                        <div class="col-6 text-end">
                            <p><strong>Customer:</strong> <?php echo $_SESSION['user_name']; ?></p>
                            <p><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="receipt-details mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Dates</th>
                                <th>Duration</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?></td>
                                <td><?php echo formatDate($data['booking']['pickup_date']); ?> - <?php echo formatDate($data['booking']['return_date']); ?></td>
                                <td><?php echo calculateDaysBetween($data['booking']['pickup_date'], $data['booking']['return_date']); ?> days</td>
                                <td><?php echo formatPrice($data['booking']['price_per_day']); ?>/day</td>
                                <td><?php echo formatPrice($data['booking']['total_price']); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th><?php echo formatPrice($data['booking']['total_price']); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="receipt-footer">
                    <p><strong>Pickup Location:</strong> <?php echo $data['booking']['pickup_location']; ?></p>
                    <p><strong>Return Location:</strong> <?php echo $data['booking']['return_location']; ?></p>
                    <p class="text-center mt-4">Thank you for choosing <?php echo SITENAME; ?>!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print me-2"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function printReceipt() {
        const printContents = document.getElementById('printReceiptContent').innerHTML;
        const originalContents = document.body.innerHTML;
        
        document.body.innerHTML = `
            <html>
                <head>
                    <title>Booking Receipt</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .text-center { text-align: center; }
                        .text-end { text-align: right; }
                        .mb-4 { margin-bottom: 1.5rem; }
                        .mt-4 { margin-top: 1.5rem; }
                        table { width: 100%; border-collapse: collapse; }
                        table, th, td { border: 1px solid #ddd; }
                        th, td { padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            </html>
        `;
        
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>