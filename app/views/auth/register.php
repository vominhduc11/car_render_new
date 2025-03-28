<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITENAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/auth.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo ASSETS_URL; ?>/images/favicon.ico">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="auth-wrapper">
                        <div class="row g-0">
                            <!-- Auth Banner -->
                            <div class="col-lg-6 auth-banner">
                                <div class="auth-banner-content">
                                    <div class="auth-logo">
                                        <a href="<?php echo URLROOT; ?>">
                                            <i class="fas fa-car"></i> <?php echo SITENAME; ?>
                                        </a>
                                    </div>
                                    <div class="auth-banner-text">
                                        <h2>Welcome to <?php echo SITENAME; ?>!</h2>
                                        <p>Create an account and start renting premium cars today.</p>
                                    </div>
                                    <div class="auth-banner-image">
                                        <img src="<?php echo ASSETS_URL; ?>/images/auth-car.png" alt="Car Illustration" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Auth Form -->
                            <div class="col-lg-6 auth-form">
                                <div class="auth-form-wrapper">
                                    <div class="auth-form-header">
                                        <h3>Create an Account</h3>
                                        <p>Fill in your details to register</p>
                                    </div>
                                    
                                    <?php echo displayFlashMessage(); ?>
                                    
                                    <form action="<?php echo URLROOT; ?>/auth/register" method="POST">
                                        <!-- CSRF Token -->
                                        <?php echo csrfField(); ?>
                                        
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="username" name="username" value="<?php echo $data['username']; ?>" 
                                                       placeholder="Choose a username" required>
                                                <div class="invalid-feedback"><?php echo $data['username_err']; ?></div>
                                            </div>
                                            <small class="text-muted">Username must be at least 3 characters</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="email" name="email" value="<?php echo $data['email']; ?>" 
                                                       placeholder="Enter your email" required>
                                                <div class="invalid-feedback"><?php echo $data['email_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="text" class="form-control <?php echo (!empty($data['full_name_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="full_name" name="full_name" value="<?php echo $data['full_name']; ?>" 
                                                       placeholder="Enter your full name" required>
                                                <div class="invalid-feedback"><?php echo $data['full_name_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="tel" class="form-control <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="phone" name="phone" value="<?php echo $data['phone']; ?>" 
                                                       placeholder="Enter your phone number" required>
                                                <div class="invalid-feedback"><?php echo $data['phone_err']; ?></div>
                                            </div>
                                            <small class="text-muted">Enter a valid 10-11 digit phone number</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address (Optional)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <textarea class="form-control" id="address" name="address" rows="2" 
                                                          placeholder="Enter your address"><?php echo $data['address']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                                           id="password" name="password" placeholder="Enter password" required>
                                                    <div class="invalid-feedback"><?php echo $data['password_err']; ?></div>
                                                </div>
                                                <small class="text-muted">Password must be at least 6 characters</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                                           id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                                                    <div class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="<?php echo URLROOT; ?>/home/terms" target="_blank">Terms and Conditions</a>
                                            </label>
                                        </div>
                                        
                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>
                                        
                                        <div class="auth-divider">
                                            <span>OR</span>
                                        </div>
                                        
                                        <div class="text-center">
                                            <p class="mb-0">Already have an account? <a href="<?php echo URLROOT; ?>/auth/login" class="auth-link">Login</a></p>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="auth-footer">
                                    <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITENAME; ?>. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo ASSETS_URL; ?>/js/validation.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password match validation
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            
            function validatePasswordMatch() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            }
            
            passwordInput.addEventListener('change', validatePasswordMatch);
            confirmPasswordInput.addEventListener('keyup', validatePasswordMatch);
        });
    </script>
</body>
</html>