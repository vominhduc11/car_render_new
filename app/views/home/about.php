<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">About Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0 animate-on-scroll" data-animation="fadeInLeft">
                <img src="<?php echo ASSETS_URL; ?>/images/about-us.jpg" alt="About Us" class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-lg-6 animate-on-scroll" data-animation="fadeInRight">
                <h2 class="section-title">Our Story</h2>
                <p class="lead mb-4">Providing premium car rental services since 2010.</p>
                <p>At <?php echo SITENAME; ?>, we believe that everyone deserves access to reliable, comfortable, and affordable transportation. Our journey began in 2010 with a small fleet of just 5 cars and a vision to revolutionize the car rental industry in Vietnam.</p>
                <p>Today, we're proud to offer a diverse fleet of over 100 vehicles ranging from economy cars to luxury SUVs, all maintained to the highest standards of safety and comfort. Our commitment to exceptional customer service and transparent pricing has made us one of the most trusted car rental companies in the region.</p>
                <p>Whether you're traveling for business or leisure, our dedicated team is here to provide you with a seamless rental experience from start to finish.</p>
                <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary mt-3">Explore Our Fleet</a>
            </div>
        </div>
        
        <div class="row mt-5 pt-5">
            <div class="col-12 text-center animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title">Our Mission & Vision</h2>
                <hr class="divider my-4">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4">
                            <i class="fas fa-bullseye text-primary fa-3x"></i>
                        </div>
                        <h3 class="card-title">Our Mission</h3>
                        <p class="card-text">To provide our customers with safe, reliable, and affordable car rental services while delivering exceptional customer experiences through transparency, convenience, and personalized solutions.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4">
                            <i class="fas fa-eye text-primary fa-3x"></i>
                        </div>
                        <h3 class="card-title">Our Vision</h3>
                        <p class="card-text">To become the leading car rental service in Vietnam, known for our quality vehicles, innovative solutions, and customer-first approach, while continuously expanding our fleet and services to meet evolving market demands.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="core-values-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title">Our Core Values</h2>
                <p class="section-subtitle">The principles that guide our business every day</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-handshake fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Integrity</h3>
                    <p>We conduct our business with honesty, transparency, and ethical principles, ensuring that our customers always receive what they were promised.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-heart fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Customer Focus</h3>
                    <p>We put our customers at the heart of everything we do, constantly striving to exceed their expectations and create memorable experiences.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Safety</h3>
                    <p>Safety is our top priority. We maintain our vehicles to the highest standards and provide comprehensive insurance coverage for peace of mind.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="300">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-lightbulb fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Innovation</h3>
                    <p>We continuously seek new ways to improve our services, embrace technology, and create efficient solutions for a seamless customer experience.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Teamwork</h3>
                    <p>We believe in the power of collaboration and foster a supportive work environment where everyone contributes to our shared success.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="500">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-3">
                        <i class="fas fa-leaf fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4">Sustainability</h3>
                    <p>We are committed to reducing our environmental impact through fuel-efficient vehicles, regular maintenance, and sustainable business practices.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title">Meet Our Team</h2>
                <p class="section-subtitle">The dedicated professionals behind our success</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="team-card text-center">
                    <div class="team-img mb-3">
                        <img src="<?php echo ASSETS_URL; ?>/images/team-1.jpg" alt="Team Member" class="img-fluid rounded-circle">
                    </div>
                    <h4 class="team-name">John Doe</h4>
                    <p class="team-position text-muted">CEO & Founder</p>
                    <div class="team-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="team-card text-center">
                    <div class="team-img mb-3">
                        <img src="<?php echo ASSETS_URL; ?>/images/team-2.jpg" alt="Team Member" class="img-fluid rounded-circle">
                    </div>
                    <h4 class="team-name">Jane Smith</h4>
                    <p class="team-position text-muted">Operations Manager</p>
                    <div class="team-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="team-card text-center">
                    <div class="team-img mb-3">
                        <img src="<?php echo ASSETS_URL; ?>/images/team-3.jpg" alt="Team Member" class="img-fluid rounded-circle">
                    </div>
                    <h4 class="team-name">Michael Brown</h4>
                    <p class="team-position text-muted">Fleet Manager</p>
                    <div class="team-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 animate-on-scroll" data-animation="fadeInUp" data-delay="300">
                <div class="team-card text-center">
                    <div class="team-img mb-3">
                        <img src="<?php echo ASSETS_URL; ?>/images/team-4.jpg" alt="Team Member" class="img-fluid rounded-circle">
                    </div>
                    <h4 class="team-name">Emily Johnson</h4>
                    <p class="team-position text-muted">Customer Service Manager</p>
                    <div class="team-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="achievements-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5 animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title text-white">Our Achievements</h2>
                <p class="section-subtitle text-white-50">Milestones we've reached along the way</p>
            </div>
        </div>
        
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 animate-on-scroll" data-animation="fadeInUp" data-delay="0">
                <div class="achievement-item">
                    <div class="achievement-icon mb-3">
                        <i class="fas fa-car fa-3x"></i>
                    </div>
                    <h3 class="achievement-number counter" data-count="100">0</h3>
                    <p class="achievement-text">Cars in Fleet</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 animate-on-scroll" data-animation="fadeInUp" data-delay="100">
                <div class="achievement-item">
                    <div class="achievement-icon mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="achievement-number counter" data-count="5000">0</h3>
                    <p class="achievement-text">Happy Customers</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <div class="achievement-item">
                    <div class="achievement-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-3x"></i>
                    </div>
                    <h3 class="achievement-number counter" data-count="10">0</h3>
                    <p class="achievement-text">Locations</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="300">
                <div class="achievement-item">
                    <div class="achievement-icon mb-3">
                        <i class="fas fa-trophy fa-3x"></i>
                    </div>
                    <h3 class="achievement-number counter" data-count="15">0</h3>
                    <p class="achievement-text">Awards Won</p>
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
                    <h2 class="cta-title">Ready to Experience Our Service?</h2>
                    <p class="cta-text">Browse our fleet and book your perfect vehicle today!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary btn-lg hover-scale">Explore Our Cars</a>
                </div>
            </div>
        </div>
    </div>
</section>