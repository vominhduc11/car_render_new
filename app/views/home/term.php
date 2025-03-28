<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">Terms and Conditions</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Terms and Conditions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Terms and Conditions Section -->
<section class="terms-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="terms-wrapper bg-white p-4 p-md-5 rounded shadow-sm">
                    <div class="last-updated text-muted mb-4">
                        <i class="fas fa-calendar-alt me-2"></i> Last Updated: January 1, 2023
                    </div>
                    
                    <div class="terms-intro mb-5">
                        <p>Welcome to <?php echo SITENAME; ?>. These Terms and Conditions govern your use of our website and services. By accessing or using our website, booking a vehicle, or using any of our services, you agree to be bound by these Terms and Conditions.</p>
                        <p>Please read these Terms and Conditions carefully before using our services. If you do not agree with any part of these terms, you may not use our services.</p>
                    </div>
                    
                    <div class="terms-content">
                        <h3>1. Definitions</h3>
                        <p>In these Terms and Conditions:</p>
                        <ul>
                            <li>"We", "us", "our", and "<?php echo SITENAME; ?>" refer to <?php echo SITENAME; ?>, its owners, directors, employees, and affiliates.</li>
                            <li>"You" and "your" refer to the customer, the person who is renting a vehicle from us.</li>
                            <li>"Vehicle" refers to the car, including all parts and accessories, that is rented to you.</li>
                            <li>"Rental Agreement" refers to the contract between you and <?php echo SITENAME; ?> for the rental of a vehicle.</li>
                            <li>"Website" refers to <?php echo URLROOT; ?> and all its subdomains.</li>
                        </ul>
                        
                        <h3>2. Booking and Reservation</h3>
                        <p>2.1. To make a booking, you must:</p>
                        <ul>
                            <li>Be at least 21 years of age;</li>
                            <li>Possess a valid driver's license that has been held for at least one year;</li>
                            <li>Have a valid credit card in your name for the security deposit.</li>
                        </ul>
                        
                        <p>2.2. A booking is confirmed only when you receive a booking confirmation from us, which will be sent to the email address provided during the booking process.</p>
                        
                        <p>2.3. We reserve the right to refuse any booking at our discretion.</p>
                        
                        <h3>3. Rental Charges and Payment</h3>
                        <p>3.1. The rental charges will be as specified in your booking confirmation. These charges may include:</p>
                        <ul>
                            <li>Base rental rate per day;</li>
                            <li>Insurance fees;</li>
                            <li>Additional services or equipment;</li>
                            <li>Taxes and surcharges.</li>
                        </ul>
                        
                        <p>3.2. Payment must be made using a valid credit card at the time of booking or vehicle pickup, as specified in your booking confirmation.</p>
                        
                        <p>3.3. A security deposit will be required at the time of vehicle pickup. The amount will be specified in your booking confirmation.</p>
                        
                        <h3>4. Vehicle Pickup and Return</h3>
                        <p>4.1. You must pick up and return the vehicle at the agreed times and locations specified in your booking confirmation.</p>
                        
                        <p>4.2. Late returns may incur additional charges at our current daily rate plus a late return fee.</p>
                        
                        <p>4.3. At the time of pickup, you must present:</p>
                        <ul>
                            <li>A valid driver's license;</li>
                            <li>The credit card used for booking;</li>
                            <li>A valid ID or passport.</li>
                        </ul>
                        
                        <p>4.4. You acknowledge that you have received the vehicle in good condition, with a full fuel tank (unless otherwise specified), and with all the necessary documents and accessories.</p>
                        
                        <h3>5. Your Responsibilities</h3>
                        <p>5.1. During the rental period, you are responsible for:</p>
                        <ul>
                            <li>The vehicle and its accessories;</li>
                            <li>Any damage to the vehicle, regardless of fault;</li>
                            <li>Any traffic violations, fines, or penalties incurred;</li>
                            <li>Ensuring that the vehicle is operated in accordance with all applicable laws and regulations.</li>
                        </ul>
                        
                        <p>5.2. You agree not to:</p>
                        <ul>
                            <li>Use the vehicle for any illegal purpose;</li>
                            <li>Use the vehicle while under the influence of alcohol, drugs, or any other substance that may impair your ability to drive;</li>
                            <li>Use the vehicle off-road or in conditions for which it was not designed;</li>
                            <li>Use the vehicle to transport dangerous, hazardous, or prohibited items;</li>
                            <li>Use the vehicle to push or tow another vehicle;</li>
                            <li>Allow anyone other than the authorized drivers specified in the Rental Agreement to drive the vehicle;</li>
                            <li>Drive the vehicle outside the authorized geographical limits specified in the Rental Agreement.</li>
                        </ul>
                        
                        <h3>6. Insurance and Liability</h3>
                        <p>6.1. Basic insurance coverage is included in the rental charges, subject to the terms and conditions of our insurance policy.</p>
                        
                        <p>6.2. You are responsible for any damage to the vehicle that is not covered by insurance, including but not limited to:</p>
                        <ul>
                            <li>Damage caused by negligence or violation of traffic laws;</li>
                            <li>Damage to tires, wheels, glass, undercarriage, or interior of the vehicle;</li>
                            <li>Damage caused by driving under the influence;</li>
                            <li>Damage caused by unauthorized drivers.</li>
                        </ul>
                        
                        <p>6.3. In the event of an accident, theft, or damage to the vehicle, you must:</p>
                        <ul>
                            <li>Notify us immediately;</li>
                            <li>File a police report, if required;</li>
                            <li>Provide all necessary information and documentation as requested by us or our insurers.</li>
                        </ul>
                        
                        <h3>7. Cancellation and Modification</h3>
                        <p>7.1. Cancellation Policy:</p>
                        <ul>
                            <li>Cancellations made at least 24 hours before the scheduled pickup time are free of charge;</li>
                            <li>Late cancellations (less than 24 hours before pickup) may incur a cancellation fee of up to one day's rental charge;</li>
                            <li>No-shows will be charged the full rental amount.</li>
                        </ul>
                        
                        <p>7.2. Modifications to your booking can be made subject to availability and may result in a change of rates.</p>
                        
                        <h3>8. Privacy Policy</h3>
                        <p>8.1. We collect and process your personal information in accordance with our Privacy Policy, which is incorporated into these Terms and Conditions by reference.</p>
                        
                        <h3>9. Intellectual Property</h3>
                        <p>9.1. All content on our website, including but not limited to text, graphics, logos, images, and software, is the property of <?php echo SITENAME; ?> and is protected by copyright and other intellectual property laws.</p>
                        
                        <p>9.2. You may not reproduce, distribute, modify, or create derivative works from any content on our website without our express written consent.</p>
                        
                        <h3>10. Limitation of Liability</h3>
                        <p>10.1. To the extent permitted by law, we shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or use, arising out of or in connection with the use of our services.</p>
                        
                        <p>10.2. Our total liability for any claims arising from or related to these Terms and Conditions shall not exceed the total amount paid by you for the rental.</p>
                        
                        <h3>11. Force Majeure</h3>
                        <p>11.1. We shall not be liable for any failure to perform our obligations under these Terms and Conditions if such failure is due to factors beyond our reasonable control, including but not limited to natural disasters, war, terrorism, strikes, riots, epidemics, or government actions.</p>
                        
                        <h3>12. Governing Law and Jurisdiction</h3>
                        <p>12.1. These Terms and Conditions shall be governed by and construed in accordance with the laws of Vietnam.</p>
                        
                        <p>12.2. Any disputes arising out of or in connection with these Terms and Conditions shall be subject to the exclusive jurisdiction of the courts of Ho Chi Minh City, Vietnam.</p>
                        
                        <h3>13. Amendments to Terms and Conditions</h3>
                        <p>13.1. We reserve the right to amend these Terms and Conditions at any time. The amended terms will be posted on our website and will be effective immediately upon posting.</p>
                        
                        <p>13.2. Your continued use of our services after the amended terms are posted constitutes your agreement to the amended terms.</p>
                        
                        <h3>14. Severability</h3>
                        <p>14.1. If any provision of these Terms and Conditions is found to be invalid or unenforceable, the remaining provisions shall remain in full force and effect.</p>
                        
                        <h3>15. Contact Information</h3>
                        <p>15.1. If you have any questions or concerns about these Terms and Conditions, please contact us at:</p>
                        <address>
                            <?php echo SITENAME; ?><br>
                            123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh<br>
                            Email: info@carrental.com<br>
                            Phone: +84 123 456 789
                        </address>
                    </div>
                    
                    <div class="terms-footer mt-5">
                        <p>By using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Links Section -->
<section class="related-links-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title">Related Information</h2>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="icon-box mb-3">
                                    <i class="fas fa-shield-alt text-primary fa-3x"></i>
                                </div>
                                <h4 class="card-title">Privacy Policy</h4>
                                <p class="card-text">Learn how we collect, use, and protect your personal information.</p>
                                <a href="<?php echo URLROOT; ?>/home/privacy" class="btn btn-outline-primary mt-3">Read Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="icon-box mb-3">
                                    <i class="fas fa-question-circle text-primary fa-3x"></i>
                                </div>
                                <h4 class="card-title">FAQs</h4>
                                <p class="card-text">Find answers to commonly asked questions about our services.</p>
                                <a href="<?php echo URLROOT; ?>/home/faq" class="btn btn-outline-primary mt-3">View FAQs</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="icon-box mb-3">
                                    <i class="fas fa-headset text-primary fa-3x"></i>
                                </div>
                                <h4 class="card-title">Contact Us</h4>
                                <p class="card-text">Have questions? Reach out to our customer support team.</p>
                                <a href="<?php echo URLROOT; ?>/home/contact" class="btn btn-outline-primary mt-3">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>