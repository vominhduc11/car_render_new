<?php require APPROOT . '/views/layouts/admin.php'; ?>

<!-- Dashboard Stats -->
<div class="container-fluid py-4">
    <?php echo displayFlashMessage(); ?>
    
    <div class="row">
        <!-- Total Cars -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-stats-card admin-stats-primary">
                <div class="admin-stats-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="admin-stats-info">
                    <h3 class="admin-stats-value"><?php echo $data['carStats']['total']; ?></h3>
                    <p class="admin-stats-label">Total Cars</p>
                    <div class="admin-stats-trend up">
                        <i class="fas fa-arrow-up"></i> <?php echo $data['carStats']['growth']; ?>% over last month
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Available Cars -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-stats-card admin-stats-success">
                <div class="admin-stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="admin-stats-info">
                    <h3 class="admin-stats-value"><?php echo $data['carStats']['available']; ?></h3>
                    <p class="admin-stats-label">Available Cars</p>
                    <div class="admin-stats-trend up">
                        <i class="fas fa-arrow-up"></i> 5% over last month
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-stats-card admin-stats-warning">
                <div class="admin-stats-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="admin-stats-info">
                    <h3 class="admin-stats-value"><?php echo $data['bookingStats']['total']; ?></h3>
                    <p class="admin-stats-label">Total Bookings</p>
                    <div class="admin-stats-trend up">
                        <i class="fas fa-arrow-up"></i> <?php echo $data['bookingStats']['growth']; ?>% over last month
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-stats-card admin-stats-danger">
                <div class="admin-stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stats-info">
                    <h3 class="admin-stats-value"><?php echo $data['userStats']['total']; ?></h3>
                    <p class="admin-stats-label">Total Users</p>
                    <div class="admin-stats-trend up">
                        <i class="fas fa-arrow-up"></i> <?php echo $data['userStats']['growth']; ?>% over last month
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-xl-8 mb-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Monthly Revenue</h5>
                    <a href="#" class="admin-card-action">View Details</a>
                </div>
                <div class="admin-card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Pending Bookings -->
        <div class="col-xl-4 mb-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Pending Bookings</h5>
                    <a href="<?php echo URLROOT; ?>/admin/bookings?status=pending" class="admin-card-action">View All</a>
                </div>
                <div class="admin-card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (empty($data['pendingBookings'])): ?>
                            <div class="list-group-item p-4 text-center">
                                <p class="text-muted mb-0">No pending bookings.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['pendingBookings'] as $booking): ?>
                                <div class="list-group-item p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="admin-badge admin-badge-warning">Pending</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?php echo $booking['full_name']; ?></h6>
                                            <p class="text-muted mb-0 small">
                                                <?php echo $booking['brand'] . ' ' . $booking['model']; ?> | 
                                                <?php echo formatDate($booking['pickup_date']); ?> - <?php echo formatDate($booking['return_date']); ?>
                                            </p>
                                        </div>
                                        <a href="<?php echo URLROOT; ?>/admin/bookings/view/<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-xl-8 mb-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Recent Bookings</h5>
                    <a href="<?php echo URLROOT; ?>/admin/bookings" class="admin-card-action">View All</a>
                </div>
                <div class="admin-card-body p-0">
                    <div class="admin-table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Dates</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data['recentBookings'])): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No bookings found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($data['recentBookings'] as $booking): ?>
                                        <tr>
                                            <td>#<?php echo $booking['id']; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-2">
                                                        <div class="fw-semibold"><?php echo $booking['full_name']; ?></div>
                                                        <div class="text-muted small"><?php echo $booking['phone']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $booking['brand'] . ' ' . $booking['model']; ?></td>
                                            <td>
                                                <div><?php echo formatDate($booking['pickup_date']); ?></div>
                                                <div><?php echo formatDate($booking['return_date']); ?></div>
                                            </td>
                                            <td><?php echo formatPrice($booking['total_price']); ?></td>
                                            <td>
                                                <?php 
                                                    switch($booking['status']) {
                                                        case 'pending':
                                                            echo '<span class="admin-badge admin-badge-warning">Pending</span>';
                                                            break;
                                                        case 'confirmed':
                                                            echo '<span class="admin-badge admin-badge-primary">Confirmed</span>';
                                                            break;
                                                        case 'completed':
                                                            echo '<span class="admin-badge admin-badge-success">Completed</span>';
                                                            break;
                                                        case 'cancelled':
                                                            echo '<span class="admin-badge admin-badge-danger">Cancelled</span>';
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo URLROOT; ?>/admin/bookings/view/<?php echo $booking['id']; ?>" class="admin-btn admin-btn-sm admin-btn-info" data-bs-toggle="tooltip" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo URLROOT; ?>/admin/bookings/edit/<?php echo $booking['id']; ?>" class="admin-btn admin-btn-sm admin-btn-primary" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats & Actions -->
        <div class="col-xl-4">
            <!-- Monthly Revenue -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Monthly Revenue</h5>
                </div>
                <div class="admin-card-body text-center">
                    <h3 class="text-primary mb-3"><?php echo formatPrice($data['monthlyRevenue']); ?></h3>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $data['revenueGrowthPercentage']; ?>%;" aria-valuenow="<?php echo $data['revenueGrowthPercentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-arrow-up text-success me-1"></i> 
                        <?php echo $data['revenueGrowthPercentage']; ?>% increase from last month
                    </p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Quick Actions</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?php echo URLROOT; ?>/admin/cars/add" class="admin-btn admin-btn-primary w-100 mb-2">
                                <i class="fas fa-plus-circle admin-btn-icon"></i> Add New Car
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo URLROOT; ?>/admin/bookings?status=pending" class="admin-btn admin-btn-warning w-100 mb-2">
                                <i class="fas fa-clock admin-btn-icon"></i> Pending Bookings
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo URLROOT; ?>/admin/users" class="admin-btn admin-btn-info w-100">
                                <i class="fas fa-users admin-btn-icon"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo URLROOT; ?>/admin/settings" class="admin-btn admin-btn-outline w-100">
                                <i class="fas fa-cog admin-btn-icon"></i> Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Info -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">System Information</h5>
                </div>
                <div class="admin-card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Version</span>
                            <span class="fw-semibold"><?php echo APP_VERSION; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>PHP Version</span>
                            <span class="fw-semibold"><?php echo phpversion(); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Database</span>
                            <span class="fw-semibold">MySQL</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Server Time</span>
                            <span class="fw-semibold"><?php echo date('Y-m-d H:i:s'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            const revenueChart = new Chart(revenueCanvas, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(array_keys($data['revenueByMonth'])); ?>,
                    datasets: [{
                        label: 'Revenue (VND)',
                        data: <?php echo json_encode(array_values($data['revenueByMonth'])); ?>,
                        backgroundColor: 'rgba(74, 111, 220, 0.2)',
                        borderColor: 'rgba(74, 111, 220, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' đ';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString() + ' đ';
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>