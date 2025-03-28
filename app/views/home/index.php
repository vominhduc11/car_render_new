<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 animate-on-scroll" data-animation="fadeInLeft">
                <div class="hero-content text-start">
                    <h1 class="hero-title">Rent the Perfect Car for Your Journey</h1>
                    <p class="hero-subtitle">Explore our diverse fleet of quality vehicles at affordable rates. Your adventure begins with us!</p>
                    <div class="hero-buttons mt-4">
                        <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary btn-lg me-3 hover-up">Browse Cars</a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg hover-up">How It Works</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block animate-on-scroll" data-animation="fadeInRight">
                <img src="<?php echo ASSETS_URL; ?>/images/hero-car.png" alt="Car Rental" class="img-fluid hero-car-image">
            </div>
        </div>
    </div>
</section>

<!-- Search Form Section -->
<section class="search-section">
    <div class="container">
        <div class="search-form animate-on-scroll" data-animation="fadeInUp">
            <form action="<?php echo URLROOT; ?>/car/search" method="GET">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pickup_date">Pickup Date</label>
                            <input type="date" id="pickup_date" name="pickup_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="return_date">Return Date</label>
                            <input type="date" id="return_date" name="return_date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group d-flex flex-column h-100">
                            <label for="search">Find Your Ideal Car</label>
                            <div class="input-group flex-grow-1">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Car brand, model...">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Featured Cars Section -->
<section class="featured-cars-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5 animate-on-scroll" data-animation="fadeIn">
            <h2 class="section-title">Our Featured Cars</h2>
            <p class="section-subtitle">Explore our premium selection of vehicles ready for your next adventure</p>
        </div>
        
        <div class="row">
            <?php if(empty($data['featuredCars'])): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No cars available at the moment. Please check back later.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['featuredCars'] as $index => $car): ?>
                    <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="<?php echo $index * 100; ?>">
                        <div class="car-card">
                            <div class="car-image">
                                <img src="<?php echo !empty($car['image']) ? URLROOT . '/uploads/cars/' . $car['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
                            </div>
                            <div class="car-body">
                                <h5 class="car-title"><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
                                <div class="car-price mb-3"><?php echo number_format($car['price_per_day']); ?> VND/day</div>
                                <div class="car-features mb-3">
                                    <span class="car-feature"><i class="fas fa-calendar"></i> <?php echo $car['year']; ?></span>
                                    <span class="car-feature"><i class="fas fa-user"></i> <?php echo $car['seats']; ?> Seats</span>
                                    <span class="car-feature"><i class="fas fa-cog"></i> <?php echo $car['transmission'] == 'auto' ? 'Auto' : 'Manual'; ?></span>
                                </div>
                                <div class="car-status mb-3">
                                    <span class="status-available">Available</span>
                                </div>
                                <a href="<?php echo URLROOT; ?>/car/details/<?php echo $car['id']; ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="col-12 text-center mt-4 animate-on-scroll" data-animation="fadeIn">
                    <a href="<?php echo URLROOT; ?>/car" class="btn btn-outline-primary btn-lg hover-up">View All Cars</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="how-it-works-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5 animate-on-scroll" data-animation="fadeIn">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Rent a car in 3 simple steps</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="step-card text-center">
                    <div class="step-icon mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="step-title">1. Find Your Car</h3>
                    <p class="step-description">Browse our diverse fleet and select the perfect vehicle for your journey.</p>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="step-card text-center">
                    <div class="step-icon mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="step-title">2. Book Your Car</h3>
                    <p class="step-description">Select your pickup and return dates and confirm your booking details.</p>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                <div class="step-card text-center">
                    <div class="step-icon mb-4">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="step-title">3. Enjoy Your Ride</h3>
                    <p class="step-description">Pick up your car and hit the road for an unforgettable adventure.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5 animate-on-scroll" data-animation="fadeIn">
            <h2 class="section-title">Why Choose Us</h2>
            <p class="section-subtitle">Experience the difference with our premium car rental service</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="feature-title">Quality Vehicles</h3>
                    <p class="feature-description">Our fleet includes only well-maintained, reliable vehicles for your peace of mind.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3 class="feature-title">Best Price Guarantee</h3>
                    <p class="feature-description">We offer competitive pricing with no hidden fees for a transparent rental experience.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-description">Our dedicated team is always available to assist you with any questions or concerns.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="300">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Insurance Coverage</h3>
                    <p class="feature-description">All our rentals include comprehensive insurance for a worry-free journey.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5 animate-on-scroll" data-animation="fadeIn">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Hear from our satisfied customers</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="testimonial-card">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text mb-4">"Excellent service! The car was in perfect condition and the rental process was smooth and efficient. Will definitely use their services again."</p>
                    <div class="testimonial-author d-flex align-items-center">
                        <div class="testimonial-author-avatar me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="testimonial-author-name mb-0">John Smith</h5>
                            <p class="testimonial-author-location mb-0">New York, USA</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text mb-4">"Great experience renting from this company. The staff was friendly and helpful, and the car was clean and fuel-efficient. Highly recommended!"</p>
                    <div class="testimonial-author d-flex align-items-center">
                        <div class="testimonial-author-avatar me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="testimonial-author-name mb-0">Sarah Johnson</h5>
                            <p class="testimonial-author-location mb-0">London, UK</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testimonial-text mb-4">"I've rented cars from many companies, but this one stands out for their exceptional customer service and well-maintained vehicles. Will definitely be my first choice in the future."</p>
                    <div class="testimonial-author d-flex align-items-center">
                        <div class="testimonial-author-avatar me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="testimonial-author-name mb-0">David Chen</h5>
                            <p class="testimonial-author-location mb-0">Sydney, Australia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-card animate-on-scroll" data-animation="fadeIn">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="cta-title">Ready to Start Your Journey?</h2>
                    <p class="cta-text">Browse our available cars and book your perfect vehicle today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary btn-lg hover-scale">Browse Cars Now</a>
                </div>
            </div>
        </div>
    </div>
</section>