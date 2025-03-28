<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo SITENAME; ?></title>
    
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
                                        <h2>Forgot Password?</h2>
                                        <p>Don't worry! Enter your email and we'll send you a reset link.</p>
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
                                        <h3>Reset Password</h3>
                                        <p>Enter your email to receive a password reset link</p>
                                    </div>
                                    
                                    <?php echo displayFlashMessage(); ?>
                                    
                                    <form action="<?php echo URLROOT; ?>/auth/forgotPassword" method="POST">
                                        <!-- CSRF Token -->
                                        <?php echo csrfField(); ?>
                                        
                                        <div class="mb-4">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="email" name="email" value="<?php echo $data['email']; ?>" 
                                                       placeholder="Enter your registered email" required>
                                                <div class="invalid-feedback"><?php echo $data['email_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
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
</body>
</html>