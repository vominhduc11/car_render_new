<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['title']) ? $data['title'] . ' - Admin Panel' : 'Admin Panel - ' . SITENAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/admin.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/animations.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo ASSETS_URL; ?>/images/favicon.ico">
    
    <!-- Additional CSS -->
    <?php if (isset($data['extraCSS'])): ?>
        <?php echo $data['extraCSS']; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Admin Wrapper -->
    <div class="admin-wrapper">
        <!-- Admin Sidebar -->
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <div class="admin-logo">
                    <i class="fas fa-car"></i> ADMIN
                </div>
                <button class="admin-sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="admin-nav">
                <div class="admin-nav-category">
                    Dashboard
                </div>
                <ul class="list-unstyled">
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/admin" class="admin-nav-link <?php echo ($view == 'admin/dashboard') ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Overview</span>
                        </a>
                    </li>
                </ul>
                
                <div class="admin-nav-category">
                    Management
                </div>
                <ul class="list-unstyled">
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/admin/cars" class="admin-nav-link <?php echo (strpos($view, 'admin/cars') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-car"></i>
                            <span>Car Management</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/admin/bookings" class="admin-nav-link <?php echo (strpos($view, 'admin/bookings') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-calendar-check"></i>
                            <span>Booking Management</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/admin/users" class="admin-nav-link <?php echo (strpos($view, 'admin/users') !== false) ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                </ul>
                
                <div class="admin-nav-category">
                    Settings
                </div>
                <ul class="list-unstyled">
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/admin/settings" class="admin-nav-link <?php echo ($view == 'admin/settings') ? 'active' : ''; ?>">
                            <i class="fas fa-cog"></i>
                            <span>System Settings</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="<?php echo URLROOT; ?>/auth/logout" class="admin-nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Admin Content -->
        <div class="admin-content">
            <!-- Admin Header -->
            <div class="admin-header">
                <h4 class="admin-header-title">
                    <?php echo !empty($data['title']) ? $data['title'] : 'Admin Panel'; ?>
                </h4>
                
                <div class="admin-header-actions">
                    <div class="admin-notification">
                        <i class="fas fa-bell"></i>
                        <span class="admin-notification-badge">3</span>
                    </div>
                    
                    <div class="admin-user-dropdown dropdown">
                        <a href="#" class="dropdown-toggle text-decoration-none" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="admin-user-avatar">
                                <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                            </div>
                            <span class="admin-user-name d-none d-md-inline-block">
                                <?php echo $_SESSION['user_name']; ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminUserDropdown">
                            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/user/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin/settings"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="container-fluid py-4">
                <?php displayFlashMessage(); ?>
                
                <!-- The actual view content will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
    
    <!-- Additional JS -->
    <?php if (isset($data['extraJS'])): ?>
        <?php echo $data['extraJS']; ?>
    <?php endif; ?>
</body>
</html>