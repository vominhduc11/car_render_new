<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- User Profile Section -->
<section class="user-profile-section py-5">
    <div class="container">
        <?php echo displayFlashMessage(); ?>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="user-sidebar card shadow-sm">
                    <div class="card-body p-0">
                        <div class="user-info text-center p-4 border-bottom">
                            <div class="user-avatar mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                            <h4 class="mb-0"><?php echo $_SESSION['user_name']; ?></h4>
                            <p class="text-muted mb-0"><?php echo $_SESSION['user_email']; ?></p>
                        </div>
                        <div class="user-menu">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item active">
                                    <a href="<?php echo URLROOT; ?>/user/profile" class="d-flex align-items-center">
                                        <i class="fas fa-user me-3"></i> My Profile
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/user/bookings" class="d-flex align-items-center">
                                        <i class="fas fa-calendar-check me-3"></i> My Bookings
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/user/settings" class="d-flex align-items-center">
                                        <i class="fas fa-cog me-3"></i> Account Settings
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo URLROOT; ?>/auth/logout" class="d-flex align-items-center text-danger">
                                        <i class="fas fa-sign-out-alt me-3"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="col-lg-9">
                <div class="profile-content card shadow-sm">
                    <div class="card-header bg-light py-3">
                        <h4 class="card-title mb-0">My Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo URLROOT; ?>/user/profile" method="POST">
                            <!-- CSRF Token -->
                            <?php echo csrfField(); ?>
                            
                            <!-- Personal Information -->
                            <div class="mb-4">
                                <h5 class="profile-section-title">Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" value="<?php echo $data['user']['username']; ?>" disabled>
                                        <small class="text-muted">Username cannot be changed</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php echo (!empty($data['full_name_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="full_name" name="full_name" value="<?php echo $data['full_name']; ?>" required>
                                        <div class="invalid-feedback"><?php echo $data['full_name_err']; ?></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="email" name="email" value="<?php echo $data['email']; ?>" required>
                                        <div class="invalid-feedback"><?php echo $data['email_err']; ?></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="phone" name="phone" value="<?php echo $data['phone']; ?>" required>
                                        <div class="invalid-feedback"><?php echo $data['phone_err']; ?></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo $data['address']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <!-- Change Password -->
                            <div class="mb-4">
                                <h5 class="profile-section-title">Change Password</h5>
                                <p class="text-muted small">Leave these fields empty if you don't want to change your password</p>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control <?php echo (!empty($data['current_password_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="current_password" name="current_password">
                                        <div class="invalid-feedback"><?php echo $data['current_password_err']; ?></div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="new_password" name="new_password">
                                        <div class="invalid-feedback"><?php echo $data['new_password_err']; ?></div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                               id="confirm_password" name="confirm_password">
                                        <div class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Save Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Account Activity Section -->
<section class="account-activity-section py-5 bg-light">
    <div class="container">
        <h4 class="mb-4">Recent Activity</h4>
        
        <div class="row">
            <!-- Recent Bookings -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">Recent Bookings</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php 
                            // Get user's recent bookings
                            $userModel = new User();
                            $recentBookings = $userModel->getUserBookings($_SESSION['user_id'], null, 3);
                        ?>
                        
                        <?php if (empty($recentBookings)): ?>
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">You don't have any bookings yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentBookings as $booking): ?>
                                    <div class="list-group-item p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <?php if($booking['status'] == 'pending'): ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php elseif($booking['status'] == 'confirmed'): ?>
                                                    <span class="badge bg-success">Confirmed</span>
                                                <?php elseif($booking['status'] == 'completed'): ?>
                                                    <span class="badge bg-primary">Completed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?php echo $booking['brand'] . ' ' . $booking['model']; ?></h6>
                                                <p class="text-muted mb-0 small">
                                                    <?php echo formatDate($booking['pickup_date']); ?> - <?php echo formatDate($booking['return_date']); ?>
                                                </p>
                                            </div>
                                            <a href="<?php echo URLROOT; ?>/booking/confirm/<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer bg-white text-center">
                                <a href="<?php echo URLROOT; ?>/user/bookings" class="text-primary">View All Bookings</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Account Summary -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0">Account Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="account-stats mb-4">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="stat-card p-3 rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon me-3">
                                                <i class="fas fa-calendar-check text-primary"></i>
                                            </div>
                                            <div>
                                                <?php 
                                                    // Count user's bookings
                                                    $totalBookings = count($userModel->getUserBookings($_SESSION['user_id']));
                                                ?>
                                                <h3 class="mb-0"><?php echo $totalBookings; ?></h3>
                                                <p class="text-muted mb-0">Total Bookings</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="stat-card p-3 rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon me-3">
                                                <i class="fas fa-car text-success"></i>
                                            </div>
                                            <div>
                                                <?php 
                                                    // Count active bookings
                                                    $bookingModel = new Booking();
                                                    $activeBookings = $bookingModel->getUserActiveBookingsCount($_SESSION['user_id']);
                                                ?>
                                                <h3 class="mb-0"><?php echo $activeBookings; ?></h3>
                                                <p class="text-muted mb-0">Active Bookings</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card p-3 rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon me-3">
                                                <i class="fas fa-clock text-warning"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0"><?php echo timeElapsed($data['user']['created_at']); ?></h3>
                                                <p class="text-muted mb-0">Member Since</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card p-3 rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon me-3">
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                            <div>
                                                <?php 
                                                    // Get preferred brand
                                                    $userBookings = $userModel->getUserBookings($_SESSION['user_id']);
                                                    $brands = [];
                                                    
                                                    foreach ($userBookings as $booking) {
                                                        if (!isset($brands[$booking['brand']])) {
                                                            $brands[$booking['brand']] = 0;
                                                        }
                                                        $brands[$booking['brand']]++;
                                                    }
                                                    
                                                    arsort($brands);
                                                    $preferredBrand = !empty($brands) ? array_key_first($brands) : 'N/A';
                                                ?>
                                                <h3 class="mb-0"><?php echo $preferredBrand; ?></h3>
                                                <p class="text-muted mb-0">Preferred Brand</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="account-info">
                            <h6>Account Info</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="text-muted">Account ID:</td>
                                    <td><?php echo $data['user']['id']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Account Type:</td>
                                    <td><?php echo ucfirst($data['user']['role']); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Registration Date:</td>
                                    <td><?php echo formatDate($data['user']['created_at']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>