<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITENAME; ?></title>
    
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
                                        <h2>Welcome Back!</h2>
                                        <p>Login to access your account and manage your bookings.</p>
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
                                        <h3>Login</h3>
                                        <p>Enter your credentials to access your account</p>
                                    </div>
                                    
                                    <?php echo displayFlashMessage(); ?>
                                    
                                    <form action="<?php echo URLROOT; ?>/auth/login" method="POST">
                                        <!-- CSRF Token -->
                                        <?php echo csrfField(); ?>
                                        
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="username" name="username" value="<?php echo $data['username']; ?>" 
                                                       placeholder="Enter your username" required>
                                                <div class="invalid-feedback"><?php echo $data['username_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                                       id="password" name="password" placeholder="Enter your password" required>
                                                <div class="invalid-feedback"><?php echo $data['password_err']; ?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">Remember me</label>
                                            </div>
                                            <a href="<?php echo URLROOT; ?>/auth/forgotPassword" class="auth-link">Forgot Password?</a>
                                        </div>
                                        
                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                        </div>
                                        
                                        <div class="auth-divider">
                                            <span>OR</span>
                                        </div>
                                        
                                        <div class="text-center">
                                            <p class="mb-0">Don't have an account? <a href="<?php echo URLROOT; ?>/auth/register" class="auth-link">Register</a></p>
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
</body>
</html>