<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Booking Create Section -->
<section class="booking-create-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/car">Cars</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/car/details/<?php echo $data['car']['id']; ?>"><?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">New Booking</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Booking Form -->
            <div class="col-lg-8 mb-4">
                <div class="booking-form-wrapper card shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h3 class="card-title mb-0">New Booking</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo URLROOT; ?>/booking/create/<?php echo $data['car']['id']; ?>" method="POST">
                            <!-- CSRF Token -->
                            <?php echo csrfField(); ?>
                            
                            <div class="row">
                                <!-- Pickup and Return Dates -->
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_date" class="form-label">Pickup Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php echo (!empty($data['pickup_date_err'])) ? 'is-invalid' : ''; ?>" 
                                           id="pickup_date" name="pickup_date" value="<?php echo $data['pickup_date']; ?>" 
                                           min="<?php echo date('Y-m-d'); ?>" required>
                                    <div class="invalid-feedback"><?php echo $data['pickup_date_err']; ?></div>
                                    <small class="text-muted">The date you will pick up the car</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="return_date" class="form-label">Return Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php echo (!empty($data['return_date_err'])) ? 'is-invalid' : ''; ?>" 
                                           id="return_date" name="return_date" value="<?php echo $data['return_date']; ?>" 
                                           min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                    <div class="invalid-feedback"><?php echo $data['return_date_err']; ?></div>
                                    <small class="text-muted">The date you will return the car</small>
                                </div>
                                
                                <!-- Pickup and Return Locations -->
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_location" class="form-label">Pickup Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo (!empty($data['pickup_location_err'])) ? 'is-invalid' : ''; ?>" 
                                           id="pickup_location" name="pickup_location" value="<?php echo $data['pickup_location']; ?>" 
                                           placeholder="Enter pickup location" required>
                                    <div class="invalid-feedback"><?php echo $data['pickup_location_err']; ?></div>
                                    <small class="text-muted">Where you will pick up the car</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="return_location" class="form-label">Return Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo (!empty($data['return_location_err'])) ? 'is-invalid' : ''; ?>" 
                                           id="return_location" name="return_location" value="<?php echo $data['return_location']; ?>" 
                                           placeholder="Enter return location" required>
                                    <div class="invalid-feedback"><?php echo $data['return_location_err']; ?></div>
                                    <small class="text-muted">Where you will return the car</small>
                                </div>
                                
                                <!-- Hidden Fields -->
                                <input type="hidden" name="total_price" value="<?php echo $data['total_price']; ?>">
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="<?php echo URLROOT; ?>/home/terms" target="_blank">Terms and Conditions</a>
                                </label>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Create Booking</button>
                                <a href="<?php echo URLROOT; ?>/car/details/<?php echo $data['car']['id']; ?>" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Booking Summary -->
            <div class="col-lg-4">
                <div class="booking-summary card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h4 class="card-title mb-0">Booking Summary</h4>
                    </div>
                    <div class="card-body">
                        <!-- Car Info -->
                        <div class="car-info d-flex align-items-center mb-4">
                            <div class="car-image me-3">
                                <img src="<?php echo !empty($data['car']['image']) ? URLROOT . '/uploads/cars/' . $data['car']['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                                     alt="<?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?>" 
                                     class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                            </div>
                            <div>
                                <h5 class="mb-0"><?php echo $data['car']['brand'] . ' ' . $data['car']['model']; ?></h5>
                                <p class="text-muted mb-0"><?php echo $data['car']['year']; ?> · <?php echo $data['car']['transmission'] == 'auto' ? 'Automatic' : 'Manual'; ?> · <?php echo $data['car']['seats']; ?> Seats</p>
                            </div>
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="booking-details mb-4">
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Pickup Date:</div>
                                <div class="col-7 text-end"><?php echo formatDate($data['pickup_date']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Return Date:</div>
                                <div class="col-7 text-end"><?php echo formatDate($data['return_date']); ?></div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-5 text-muted">Duration:</div>
                                <div class="col-7 text-end"><?php echo $data['days']; ?> days</div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Cost Breakdown -->
                        <div class="cost-breakdown mb-4">
                            <div class="row mb-2">
                                <div class="col-7 text-muted">Daily Rate:</div>
                                <div class="col-5 text-end"><?php echo formatPrice($data['car']['price_per_day']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-7 text-muted">Duration (<?php echo $data['days']; ?> days):</div>
                                <div class="col-5 text-end"><?php echo 'x ' . $data['days']; ?></div>
                            </div>
                            <?php 
                                // Calculate tax (example: 10%)
                                $taxRate = 10;
                                $subtotal = $data['car']['price_per_day'] * $data['days']; 
                                $tax = ($subtotal * $taxRate) / 100;
                                $total = $subtotal + $tax;
                            ?>
                            <div class="row mb-2">
                                <div class="col-7 text-muted">Subtotal:</div>
                                <div class="col-5 text-end"><?php echo formatPrice($subtotal); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-7 text-muted">Tax (<?php echo $taxRate; ?>%):</div>
                                <div class="col-5 text-end"><?php echo formatPrice($tax); ?></div>
                            </div>
                        </div>
                        
                        <div class="total-price">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mb-0">Total:</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <h5 class="mb-0 text-primary"><?php echo formatPrice($total); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="additional-info card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Important Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Free cancellation up to 24 hours before pickup</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Insurance included</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 24/7 customer support</li>
                            <li><i class="fas fa-info-circle text-primary me-2"></i> Valid driver's license required at pickup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
        
        // Copy pickup location to return location
        const pickupLocationInput = document.getElementById('pickup_location');
        const returnLocationInput = document.getElementById('return_location');
        const copyLocationCheckbox = document.getElementById('copy_location');
        
        if (pickupLocationInput && returnLocationInput && copyLocationCheckbox) {
            copyLocationCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    returnLocationInput.value = pickupLocationInput.value;
                    returnLocationInput.disabled = true;
                } else {
                    returnLocationInput.disabled = false;
                }
            });
            
            pickupLocationInput.addEventListener('input', function() {
                if (copyLocationCheckbox.checked) {
                    returnLocationInput.value = this.value;
                }
            });
        }
    });
</script>