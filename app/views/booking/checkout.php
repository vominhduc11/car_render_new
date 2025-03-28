<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Booking Checkout Section -->
<section class="booking-checkout-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/user/bookings">My Bookings</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/booking/confirm/<?php echo $data['booking']['id']; ?>">Booking #<?php echo $data['booking']['id']; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8 mb-4">
                <div class="checkout-form-wrapper card shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h3 class="card-title mb-0">Payment Details</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo URLROOT; ?>/booking/checkout/<?php echo $data['booking']['id']; ?>" method="POST" id="payment-form">
                            <!-- CSRF Token -->
                            <?php echo csrfField(); ?>
                            
                            <!-- Payment Method Selection -->
                            <div class="payment-methods mb-4">
                                <h5 class="mb-3">Select Payment Method</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                            <label class="form-check-label payment-method-label" for="credit_card">
                                                <i class="fas fa-credit-card payment-icon"></i>
                                                <span>Credit Card</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                            <label class="form-check-label payment-method-label" for="paypal">
                                                <i class="fab fa-paypal payment-icon"></i>
                                                <span>PayPal</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                            <label class="form-check-label payment-method-label" for="bank_transfer">
                                                <i class="fas fa-university payment-icon"></i>
                                                <span>Bank Transfer</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Credit Card Details -->
                            <div id="credit_card_details">
                                <h5 class="mb-3">Card Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3">
                                        <label for="card_number" class="form-label">Card Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                            <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456" required>
                                        </div>
                                        <small class="text-muted">For testing, use: 4242 4242 4242 4242</small>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" id="expiry_date" placeholder="MM/YY" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="card_name" class="form-label">Cardholder Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-user"></i></span>
                                            <input type="text" class="form-control" id="card_name" placeholder="John Doe" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Billing Address -->
                            <div class="billing-address mb-4">
                                <h5 class="mb-3">Billing Address</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="billing_first_name" value="<?php echo explode(' ', $_SESSION['user_name'])[0]; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="billing_last_name" value="<?php echo count(explode(' ', $_SESSION['user_name'])) > 1 ? end(explode(' ', $_SESSION['user_name'])) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="billing_email" value="<?php echo $_SESSION['user_email']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="billing_phone" value="<?php echo $data['booking']['phone']; ?>" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="billing_address" class="form-label">Address</label>
                                        <textarea class="form-control" id="billing_address" rows="2" required></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="billing_city" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_zip" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control" id="billing_zip" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Privacy -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="<?php echo URLROOT; ?>/home/terms" target="_blank">Terms and Conditions</a> and <a href="<?php echo URLROOT; ?>/home/privacy" target="_blank">Privacy Policy</a>
                                </label>
                            </div>
                            
                            <!-- Payment Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Pay Now <?php echo formatPrice($data['booking']['total_price']); ?></button>
                                <a href="<?php echo URLROOT; ?>/booking/confirm/<?php echo $data['booking']['id']; ?>" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h4 class="card-title mb-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <!-- Booking Details -->
                        <div class="booking-id-wrapper mb-3">
                            <span class="booking-id">Booking #<?php echo $data['booking']['id']; ?></span>
                        </div>
                        
                        <!-- Car Info -->
                        <div class="car-info d-flex align-items-center mb-4">
                            <div class="car-image me-3">
                                <img src="<?php echo !empty($data['booking']['image']) ? URLROOT . '/uploads/cars/' . $data['booking']['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" 
                                     alt="<?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?>" 
                                     class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                            </div>
                            <div>
                                <h5 class="mb-0"><?php echo $data['booking']['brand'] . ' ' . $data['booking']['model']; ?></h5>
                                <p class="text-muted mb-0"><?php echo formatDate($data['booking']['pickup_date']); ?> - <?php echo formatDate($data['booking']['return_date']); ?></p>
                            </div>
                        </div>
                        
                        <!-- Cost Breakdown -->
                        <div class="cost-breakdown mb-4">
                            <?php 
                                // Calculate number of days
                                $days = calculateDaysBetween($data['booking']['pickup_date'], $data['booking']['return_date']);
                                
                                // Calculate subtotal
                                $subtotal = $data['booking']['price_per_day'] * $days;
                                
                                // Calculate tax (example: 10%)
                                $taxRate = 10;
                                $tax = ($subtotal * $taxRate) / 100;
                                
                                // Calculate total
                                $total = $subtotal + $tax;
                            ?>
                            
                            <div class="row mb-2">
                                <div class="col-8 text-muted">Daily Rate:</div>
                                <div class="col-4 text-end"><?php echo formatPrice($data['booking']['price_per_day']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8 text-muted">Duration:</div>
                                <div class="col-4 text-end"><?php echo $days; ?> days</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8 text-muted">Subtotal:</div>
                                <div class="col-4 text-end"><?php echo formatPrice($subtotal); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8 text-muted">Tax (<?php echo $taxRate; ?>%):</div>
                                <div class="col-4 text-end"><?php echo formatPrice($tax); ?></div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Total -->
                        <div class="total-price mb-4">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">Total:</h5>
                                </div>
                                <div class="col-4 text-end">
                                    <h5 class="mb-0 text-primary"><?php echo formatPrice($data['booking']['total_price']); ?></h5>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="payment-methods-accepted text-center">
                            <p class="text-muted mb-2">We Accept</p>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa fa-2x me-2"></i>
                                <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                                <i class="fab fa-cc-amex fa-2x me-2"></i>
                                <i class="fab fa-cc-paypal fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Need Help? -->
                <div class="need-help card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Need Help?</h5>
                        <p class="text-muted">If you have any questions about your booking or payment, please contact our customer support.</p>
                        <div class="d-grid">
                            <a href="<?php echo URLROOT; ?>/home/contact" class="btn btn-outline-primary">
                                <i class="fas fa-headset me-2"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Payment -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method toggle
        const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('credit_card_details');
        
        function togglePaymentDetails() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (selectedMethod === 'credit_card') {
                creditCardDetails.style.display = 'block';
            } else {
                creditCardDetails.style.display = 'none';
            }
        }
        
        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', togglePaymentDetails);
        });
        
        // Credit Card Formatting
        const cardNumberInput = document.getElementById('card_number');
        const expiryDateInput = document.getElementById('expiry_date');
        const cvvInput = document.getElementById('cvv');
        
        cardNumberInput.addEventListener('input', function(e) {
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');
            
            // Add spaces after every 4 digits
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            
            // Update input value
            this.value = value;
            
            // Limit to 19 characters (16 digits + 3 spaces)
            if (this.value.length > 19) {
                this.value = this.value.slice(0, 19);
            }
        });
        
        expiryDateInput.addEventListener('input', function(e) {
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');
            
            // Format as MM/YY
            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            
            // Update input value
            this.value = value;
            
            // Limit to 5 characters (MM/YY)
            if (this.value.length > 5) {
                this.value = this.value.slice(0, 5);
            }
        });
        
        cvvInput.addEventListener('input', function(e) {
            // Remove non-digits
            let value = this.value.replace(/\D/g, '');
            
            // Update input value
            this.value = value;
            
            // Limit to 3 or 4 digits
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        });
        
        // Form Submission - Demo only (in a real app, you'd use a payment gateway)
        const paymentForm = document.getElementById('payment-form');
        
        paymentForm.addEventListener('submit', function(e) {
            // In a real application, you would process the payment here
            // For this demo, we'll just submit the form to complete the payment
        });
    });
</script>