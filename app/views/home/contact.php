<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">Contact Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5 mb-lg-0 animate-on-scroll" data-animation="fadeInLeft">
                <div class="contact-form-wrapper card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="mb-4">Get In Touch</h2>
                        <p class="text-muted mb-4">Have questions about our car rental services? Fill out the form below and we'll get back to you as soon as possible.</p>
                        
                        <form action="<?php echo URLROOT; ?>/home/contact" method="POST" class="needs-validation" novalidate>
                            <!-- CSRF Token -->
                            <?php echo csrfField(); ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control <?php echo (!empty($data['errors']['name'])) ? 'is-invalid' : ''; ?>" 
                                               id="name" name="name" value="<?php echo $data['name']; ?>" 
                                               placeholder="Enter your name" required>
                                        <?php if (!empty($data['errors']['name'])): ?>
                                            <div class="invalid-feedback"><?php echo $data['errors']['name']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control <?php echo (!empty($data['errors']['email'])) ? 'is-invalid' : ''; ?>" 
                                               id="email" name="email" value="<?php echo $data['email']; ?>" 
                                               placeholder="Enter your email" required>
                                        <?php if (!empty($data['errors']['email'])): ?>
                                            <div class="invalid-feedback"><?php echo $data['errors']['email']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control <?php echo (!empty($data['errors']['subject'])) ? 'is-invalid' : ''; ?>" 
                                           id="subject" name="subject" value="<?php echo $data['subject']; ?>" 
                                           placeholder="Enter subject" required>
                                    <?php if (!empty($data['errors']['subject'])): ?>
                                        <div class="invalid-feedback"><?php echo $data['errors']['subject']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                    <textarea class="form-control <?php echo (!empty($data['errors']['message'])) ? 'is-invalid' : ''; ?>" 
                                              id="message" name="message" rows="5" 
                                              placeholder="Enter your message" required><?php echo $data['message']; ?></textarea>
                                    <?php if (!empty($data['errors']['message'])): ?>
                                        <div class="invalid-feedback"><?php echo $data['errors']['message']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4 animate-on-scroll" data-animation="fadeInRight">
                <div class="contact-info-wrapper">
                    <!-- Contact Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Contact Information</h3>
                            <div class="contact-info">
                                <div class="contact-info-item d-flex mb-4">
                                    <div class="contact-info-icon me-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <h5 class="mb-1">Our Location</h5>
                                        <p class="mb-0">123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                                    </div>
                                </div>
                                
                                <div class="contact-info-item d-flex mb-4">
                                    <div class="contact-info-icon me-3">
                                        <i class="fas fa-phone-alt text-primary"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <h5 class="mb-1">Phone Number</h5>
                                        <p class="mb-0">+84 123 456 789</p>
                                    </div>
                                </div>
                                
                                <div class="contact-info-item d-flex mb-4">
                                    <div class="contact-info-icon me-3">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <h5 class="mb-1">Email Address</h5>
                                        <p class="mb-0">info@carrental.com</p>
                                    </div>
                                </div>
                                
                                <div class="contact-info-item d-flex">
                                    <div class="contact-info-icon me-3">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <h5 class="mb-1">Opening Hours</h5>
                                        <p class="mb-0">Monday - Saturday: 8:00 AM - 8:00 PM</p>
                                        <p class="mb-0">Sunday: 9:00 AM - 5:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Connect With Us</h3>
                            <div class="social-links">
                                <a href="#" class="social-link" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-link" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-link" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-link" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Emergency Support -->
                    <div class="card shadow-sm bg-primary text-white">
                        <div class="card-body p-4">
                            <h3 class="mb-3">24/7 Emergency Support</h3>
                            <p class="mb-4">For roadside assistance or emergency support, please contact our dedicated hotline:</p>
                            <div class="emergency-phone">
                                <i class="fas fa-phone-alt me-2"></i> +84 987 654 321
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4 animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title">Our Location</h2>
                <p class="section-subtitle">Find us easily with our interactive map</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 animate-on-scroll" data-animation="fadeInUp">
                <div class="map-container rounded shadow-sm">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674197826!2d106.68802161483756!3d10.776891392322239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3c586421ef%3A0xb606461945d70bc1!2sHo%20Chi%20Minh%20City%2C%20Vietnam!5e0!3m2!1sen!2s!4v1619123456789!5m2!1sen!2s" 
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4 animate-on-scroll" data-animation="fadeInUp">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Quick answers to common questions about our services</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10 animate-on-scroll" data-animation="fadeInUp">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                What documents do I need to rent a car?
                            </button>
                        </h2>
                        <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                To rent a car, you will need a valid driver's license, a credit card in your name for the security deposit, and a valid ID or passport. International customers will need an International Driving Permit along with their original driver's license.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                Is there a minimum age requirement to rent a car?
                            </button>
                        </h2>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, the minimum age requirement is 21 years old. Drivers under 25 may be subject to a young driver surcharge and may have restrictions on the types of vehicles they can rent.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                Can I modify or cancel my reservation?
                            </button>
                        </h2>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can modify or cancel your reservation through your account on our website or by contacting our customer service. Cancellations made at least 24 hours before the scheduled pickup time are free of charge. Late cancellations may incur a cancellation fee.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                What is included in the rental price?
                            </button>
                        </h2>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our rental prices include basic insurance coverage, 24/7 roadside assistance, and unlimited mileage for most car categories. Additional services such as GPS, child seats, additional drivers, and premium insurance coverage are available for an extra charge.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                How do I report a problem with the rental vehicle?
                            </button>
                        </h2>
                        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                If you experience any issues with your rental vehicle, please contact our 24/7 customer support hotline immediately at +84 987 654 321. For emergencies or breakdowns, use the roadside assistance service provided with your rental.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center animate-on-scroll" data-animation="fadeInUp">
                <a href="<?php echo URLROOT; ?>/home/faq" class="btn btn-outline-primary">
                    <i class="fas fa-question-circle me-2"></i> View All FAQs
                </a>
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
                    <h2 class="cta-title">Ready to Rent a Car?</h2>
                    <p class="cta-text">Browse our fleet and find the perfect vehicle for your needs.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo URLROOT; ?>/car" class="btn btn-primary btn-lg hover-scale">
                        <i class="fas fa-car me-2"></i> View Cars
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>