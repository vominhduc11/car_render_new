<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden - <?php echo SITENAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/error.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo ASSETS_URL; ?>/images/favicon.ico">
</head>
<body>
    <div class="error-container error-403">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="error-content">
                        <div class="error-logo mb-4">
                            <a href="<?php echo URLROOT; ?>">
                                <i class="fas fa-car"></i> <?php echo SITENAME; ?>
                            </a>
                        </div>
                        
                        <div class="error-code">
                            <h1>403</h1>
                        </div>
                        
                        <div class="error-message mb-4">
                            <h2>Access Forbidden</h2>
                            <p>Sorry, you don't have permission to access this page. Please check your credentials or contact the administrator if you believe this is an error.</p>
                        </div>
                        
                        <div class="error-image mb-4">
                            <img src="<?php echo ASSETS_URL; ?>/images/error-locked.png" alt="Forbidden Access Illustration" class="img-fluid">
                        </div>
                        
                        <div class="error-actions">
                            <a href="<?php echo URLROOT; ?>" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-home me-2"></i> Back to Home
                            </a>
                            <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </a>
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