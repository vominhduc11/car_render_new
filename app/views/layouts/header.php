<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="logo navbar-brand" href="<?php echo URLROOT; ?>">
                <i class="fas fa-car"></i> Car Rental
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'home/index') ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($view, 'car/') !== false) ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>/car">Cars</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'home/about') ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>/home/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($view == 'home/contact') ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>/home/contact">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if($_SESSION['user_role'] == 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/admin"><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/user/profile"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/user/bookings"><i class="fas fa-calendar-check me-2"></i>My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($view == 'auth/login') ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>/auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($view == 'auth/register') ? 'active' : ''; ?>" href="<?php echo URLROOT; ?>/auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php displayFlashMessage(); ?>
    </div>
</header>