<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?php echo SITENAME; ?></title>
    
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
                                        <h2>Create New Password</h2>
                                        <p>Enter a new password for your account to continue.</p>
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
                                        <h3>Set New Password</h3>
                                        <p>Create a strong password for your account</p>
                                    </div>
                                    
                                    <?php echo displayFlashMessage(); ?>
                                    
                                    <form action="<?php echo URLROOT; ?>/auth/resetPassword/<?php echo $data['token']; ?>" method="POST">
                                        <!-- CSRF Token -->
                                        <?php echo csrfField(); ?>
                                        
                                        <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="password" name="password" placeholder="Enter new password" required>
                                                <div class="invalid-feedback"><?php echo $data['password_err']; ?></div>
                                            </div>
                                            <small class="text-muted">Password must be at least 6 characters</small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                                                <div class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                                        </div>
                                        
                                        <div class="auth-divider">
                                            <span>OR</span>
                                        </div>
                                        
                                        <div class="text-center">
                                            <p class="mb-0">Remember your password? <a href="<?php echo URLROOT; ?>/auth/login" class="auth-link">Back to Login</a></p>
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